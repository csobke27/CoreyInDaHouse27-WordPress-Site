import { registerBlockType } from '@wordpress/blocks';
import metadata from './block.json';
import Edit from './edit';

registerBlockType(metadata.name, {
    title: 'CoreyInDaHouse Footer',
    edit: Edit
});