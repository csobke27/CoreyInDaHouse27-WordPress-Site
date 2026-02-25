import { store, getContext } from '@wordpress/interactivity';
import axios from 'axios';

document.addEventListener('DOMContentLoaded', function() {
    let survivorPlayers = [];
    let killerPlayers = [];

    function normalizeChoiceList(source) {
        if (Array.isArray(source)) {
            return alphabetizeArray(source);
        }

        if (source && typeof source === 'object') {
            if (Array.isArray(source.choices)) {
                return alphabetizeArray(source.choices);
            }

            if (source.choices && typeof source.choices === 'object') {
                return alphabetizeArray(Object.values(source.choices));
            }

            return alphabetizeArray(Object.values(source));
        }

        return [];
    }

    function renderSurvivors(type, players) {
        const container = document.querySelector(`.${type}-options-container`);
        if (!container) return;

        // Capture scroll positions before re-rendering
        const scrollState = {};
        const previousRows = container.querySelectorAll(`.${type}-player-row`);
        previousRows.forEach((row, rowIndex) => {
            const ownedList = row.querySelector(`.owned-${type}s-list`);
            const unownedList = row.querySelector(`.unowned-${type}s-list`);
            scrollState[rowIndex] = {
                owned: ownedList ? ownedList.scrollTop : 0,
                unowned: unownedList ? unownedList.scrollTop : 0
            };
        });
        const existing = container.querySelectorAll(`.${type}-player-row`);
        existing.forEach((node) => node.remove());

        const tpl = document.getElementById(`${type}-template`);
        players.forEach((player, index) => {
            const node = tpl.content.cloneNode(true);
            const row = node.querySelector(`.${type}-player-row`);
            row.setAttribute('data-player-index', index);
            node.querySelector('.player-number').textContent = `${player.name}:`;
            node.querySelector(`.remove-${type}-btn`).setAttribute('data-index', index);
            const availableList = normalizeChoiceList(player[`${type}sAvailable`]);
            const unavailableList = normalizeChoiceList(player[`${type}sUnavailable`]);
            const ownedContainer = node.querySelector(`.owned-${type}s-list`);
            const unownedContainer = node.querySelector(`.unowned-${type}s-list`);
            ownedContainer.setAttribute('data-list-type', 'owned');
            unownedContainer.setAttribute('data-list-type', 'unowned');
            const previousScroll = scrollState[index] || { owned: 0, unowned: 0 };
            availableList.forEach(character => {
                const li = document.createElement('li');
                li.textContent = character;
                li.addEventListener('click', (event) => moveSurvivorItem(event, player, type, character, 'Available', 'Unavailable'));
                ownedContainer.appendChild(li);
            });
            unavailableList.forEach(character => {
                const li = document.createElement('li');
                li.textContent = character;
                li.addEventListener('click', (event) => moveSurvivorItem(event, player, type, character, 'Unavailable', 'Available'));
                unownedContainer.appendChild(li);
            });
            container.appendChild(node);
            // Restore scroll positions after rendering
            ownedContainer.scrollTop = previousScroll.owned;
            unownedContainer.scrollTop = previousScroll.unowned;
        });
    }

    function moveSurvivorItem(event, player, type, item, source, destination){
        event.preventDefault();

        const index = player[`${type}s${source}`].indexOf(item);
        if(index === -1) return;
        player[`${type}s${source}`].splice(index, 1);
        player[`${type}s${destination}`].push(item);
        renderSurvivors(type, type === 'survivor' ? survivorPlayers : killerPlayers);
        // renderSurvivors(survivorPlayers);
    }

    function alphabetizeArray(arr){
        return arr.sort((a, b) => a.localeCompare(b));
    }

    const survivorContainer = document.querySelector('.survivor-options-container');
    // Event delegation for dynamically added remove buttons
    if (survivorContainer) {
        survivorContainer.addEventListener('click', function(event) {
            const removeButton = event.target.closest('.remove-survivor-btn');
            if (!removeButton) return;

            const index = parseInt(removeButton.getAttribute('data-index'), 10);
            if (Number.isNaN(index)) return;

            survivorPlayers.splice(index, 1);
            survivorPlayers.forEach((player, idx) => {
                player.name = "Survivor " + (idx + 1);
            });
            renderSurvivors('survivor', survivorPlayers);
            console.log('Remove Survivor button clicked for index', index);
        });
    }

    const killerContainer = document.querySelector('.killer-options-container');
    if (killerContainer) {
        killerContainer.addEventListener('click', function(event) {
            const removeButton = event.target.closest('.remove-killer-btn');
            if (!removeButton) return;

            const index = parseInt(removeButton.getAttribute('data-index'), 10);
            if (Number.isNaN(index)) return;

            killerPlayers.splice(index, 1);
            killerPlayers.forEach((player, idx) => {
                player.name = "Killer " + (idx + 1);
            });
            renderSurvivors('killer', killerPlayers);
            console.log('Remove Killer button clicked for index', index);
        });
    }

    function displayPerks(player){
        const container = document.querySelector('.dbd-results-container');
        if (!container) return;
        const tpl = document.getElementById('perk-container-template');
        const node = tpl.content.cloneNode(true);
        const perkRow = node.querySelector('.perk-row');
        node.querySelector('.dbd-player-name').textContent = player.name + "'s Perks:";
        const perkContainer = node.querySelector('.perks-container');
        player.perks.forEach(perk => {
            const perkNode = document.getElementById('perk-card-template').content.cloneNode(true);
            perkNode.querySelector('.perk-card').addEventListener('click', function() {
                const descriptionContainer = this.closest('.perk-row').querySelector('.perk-description-container');
                const descriptionElement = descriptionContainer.querySelector('.perk-description');
                const perkName = descriptionContainer.querySelector('.perk-header');
                
                descriptionElement.innerHTML = perk.content;
                descriptionContainer.querySelector('.perk-character').textContent = perk.name + " perk";
                if (perkName.textContent === perk.title) {
                    // If the same perk is clicked again, toggle the collapse
                    const collapseElement = descriptionContainer.querySelector('#perkDescriptionCollapse');
                    const bsCollapse = new bootstrap.Collapse(collapseElement, { toggle: false });
                    if (collapseElement.classList.contains('show')) {
                        bsCollapse.hide();
                        this.classList.remove('selected-perk');
                    } else {
                        this.classList.add('selected-perk');
                        bsCollapse.show();
                    }
                } else {
                    perkName.textContent = perk.title;
                    const collapseElement = descriptionContainer.querySelector('#perkDescriptionCollapse');
                    const bsCollapse = new bootstrap.Collapse(collapseElement, { toggle: false });
                    perkContainer.querySelectorAll('.perk-card').forEach(card => card.classList.remove('selected-perk'));
                    this.classList.add('selected-perk');
                    bsCollapse.show();
                }
            });
            perkNode.querySelector('.perk-card').href = "test";
            perkNode.querySelector('.perk-card').setAttribute('aria-controls', "test");
            perkNode.querySelector('.perk-icon').src = perk.perk_icon_url;
            perkNode.querySelector('.perk-icon').alt = perk.perk_icon_alt;
            perkNode.querySelector('.perk-title').textContent = perk.title;
            perkContainer.appendChild(perkNode);
        });
        container.appendChild(node);

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                perkRow.classList.add('show');
            });
        });
    }

    function resetDisplay(){
        const container = document.querySelector('.dbd-results-container');
        if (!container) return;
        //first delete any existing perks
        const existing = container.querySelectorAll('.perk-row');
        existing.forEach((node) => node.remove());
    }

    store('survivor-template', {
        actions: {
            addSurvivor: function() {
                const context = getContext();
                if(survivorPlayers.length >= 4){
                    alert("Maximum of 4 survivors allowed");
                    return;
                }
                const newSurvivor = {
                    name: "Survivor " + (survivorPlayers.length + 1),
                    survivorsAvailable: normalizeChoiceList(context.survivorList),
                    survivorsUnavailable: [],
                    perks: []
                };
                survivorPlayers.push(newSurvivor);
                renderSurvivors('survivor', survivorPlayers);
            },
            addKiller: function() {
                const context = getContext();
                if(killerPlayers.length >= 1){
                    alert("Only one killer allowed");
                    return;
                }
                var newKiller = {
                    name: "Killer",
                    killersAvailable: normalizeChoiceList(context.killerList),
                    killersUnavailable: [],
                    perks: []
                };
                killerPlayers.push(newKiller);
                renderSurvivors('killer', killerPlayers);
            },
            generatePerks: function() {
                if(survivorPlayers.length === 0 && killerPlayers.length === 0){
                    alert("Please add at least one survivor or killer to generate perks.");
                    return;
                }
                const context = getContext();
                let data = {survivors: [], killers: []};
                survivorPlayers.forEach(player => {
                    data.survivors.push({
                        name: player.name,
                        filterSurvivors: player.survivorsUnavailable
                    });
                });
                killerPlayers.forEach(player => {
                    data.killers.push({
                        name: player.name,
                        filterKillers: player.killersUnavailable
                    });
                });
                console.log("Generating perks with data:", data);
                let generateBtn = document.getElementById('generatePerksBtn');
                generateBtn.disabled = true;
                axios.post("/wp-json/dbd-chaos-shuffle/v1/shuffle", data)
                    .then(response => {
                        console.log("Perks generated successfully:", response.data);
                        if(response.data){
                            resetDisplay();
                            response.data.survivors.forEach((survivor, index) => {
                                let timeDelay = index === 0 ? 0 : index * 1000; // 1000ms delay for each subsequent survivor
                                setTimeout(() => {
                                    displayPerks(survivor);
                                }, timeDelay);
                            });
                            response.data.killers.forEach(killer => {
                                displayPerks(killer);
                            });
                        }
                    })
                    .catch(error => {
                        console.error("Error generating perks:", error);
                })
                .finally(() => {
                    generateBtn.disabled = false;
                });
            }
        }
    });

});