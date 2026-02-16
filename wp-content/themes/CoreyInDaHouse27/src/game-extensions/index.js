import { registerBlockType } from '@wordpress/blocks';
import metadata from './block.json';
import Edit from './edit';
import './editor.css';
import './style.css';

registerBlockType(metadata.name, {
    title: 'CoreyInDaHouse - Game Extensions',
    edit: Edit
});