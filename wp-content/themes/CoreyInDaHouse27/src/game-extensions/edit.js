import { useBlockProps } from '@wordpress/block-editor';

export default function Edit() {
    const blockProps = useBlockProps();
    return (
    <div {...blockProps}>
        <div className='dahouse-placeholder-block'>Game Extensions - Rendered on Frontend</div>
    </div>
    )
}