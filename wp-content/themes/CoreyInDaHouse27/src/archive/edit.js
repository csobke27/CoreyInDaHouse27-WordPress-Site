import { useBlockProps } from '@wordpress/block-editor';

export default function Edit() {
    const blockProps = useBlockProps();
    return (
    <div {...blockProps}>
        <div className='dahouse-placeholder-block'>Archive Block - Rendered on Frontend</div>
    </div>
    )
}