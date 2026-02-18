document.addEventListener('DOMContentLoaded', function() {
    var swiper = new Swiper(".swiper-container", {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        coverflowEffect: {
            rotate: 20,
            stretch: 0,
            depth: 350,
            modifier: 1,
            slideShadows: true
        },
        pagination: {
            el: ".swiper-pagination"
        },
        on: {
            init: function() {
                // Display modes for the first slide on load
                var activeSlide = this.slides[this.activeIndex];
                var gameId = activeSlide.id;
                displayGameModes(gameId);
            },
            slideChange: function() {
                var activeSlide = this.slides[this.activeIndex];
                var gameId = activeSlide.id;
                console.log("Active game extension:", gameId);
                displayGameModes(gameId);
            }
        }
    });

    function displayGameModes(gameId) {
        var modesList = document.querySelector('.game-mode-list');
        modesList.innerHTML = ''; // Clear existing list
        
        if (window.gameModesData && window.gameModesData[gameId]) {
            var modes = window.gameModesData[gameId];
            console.log("Game modes for game ID " + gameId + ":", modes);
            if (modes.length > 0) {
                var ul = document.createElement('ul');
                // ul.className = 'mode-list';
                ul.className = 'list-group';
                var i=0;
                modes.forEach(function(mode) {
                    var li = document.createElement('li');
                    li.className = 'list-group-item';
                    if(i % 2 != 0){
                        li.className += ' list-group-item-secondary';
                    }
                    li.innerHTML = '<strong class="mode-title">' + mode.title + '</strong>';
                    if (mode.content) {
                        li.innerHTML += '<p>' + mode.content + '</p>';
                    }
                    if(mode.game_mode_page_link){
                        li.innerHTML += '<div class="mode-link"><a href="' + mode.game_mode_page_link + '" class="btn btn-primary">Use Extension</a></div>';
                    }
                    ul.appendChild(li);
                    i++;
                });
                modesList.appendChild(ul);
            } else {
                modesList.innerHTML = `
                    <div class="no-modes-placeholder">
                        <h3>No game modes available</h3>
                    </div>
                `;
            }
        } else {
            modesList.innerHTML = `
                <div class="no-modes-placeholder">
                    <h3>No game modes available</h3>
                </div>
            `;
        }
    }
});