
const { MediaUpload,RichText } = wp.editor;
const { registerBlockType }    = wp.blocks;
const { InspectorControls }    = wp.editor;
const { Button,PanelBody,TextControl }     = wp.components;
const stringData               = myBlockData.strings;
const urlimage                 = myBlockData.defaultimge;
const right                 = myBlockData.right;

registerBlockType('kzrnamespace/imagetitleblock', {
    title: stringData.image_title_block,
    icon: 'smiley',
    category: 'my-custom-category',
    attributes: {
        sectionTitle: {
            type: 'string',
            default: 'Struktura',
        },
        backgroundimage: {
            type: 'object',
            default: {
                imgurl: urlimage,
                imgealt: '',
            },
        },
    },
   
    edit: ImageRepeaterBlockEdit,
    save: function ({ attributes }) {
        const { sectionTitle, backgroundimage } = attributes;
        return (
            <>
                {sectionTitle && (
                    <div class="web-heading heading-divider">
                        <h2>{sectionTitle}</h2> 
                    </div>
                )} 
    
                {backgroundimage && backgroundimage.imgurl && (
                    <div class="structure-block">
                        <img src={backgroundimage.imgurl} alt={backgroundimage.imgealt} />
                        <div class="block-link d-lg-none">
                            <div class="block-link-row">
                              <a href={backgroundimage.imgurl} target="_blank" rel="noopener noreferrer" className="d-flex">
                                    <div class="block-link-inner d-flex align-items-center">
                                        <div class="link-content d-flex align-items-center justify-content-between">
                                            <div class="content">
                                                <p>{stringData.Zobacz}</p>
                                            </div>
                                            <div class="right-icon">
                                                <img src={right} alt="structure" />
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>	
                    </div>
                )}
            </>
        );
    },
});

function ImageRepeaterBlockEdit(props) {

    const { setAttributes, attributes } = props;
    const { backgroundimage } = attributes;

    function openMediaLibrarybackground() {
        const mediaLibrary = wp.media({
            title: 'Select Image',
            multiple: false,
        });

        mediaLibrary.on('select', function () {
            const media = mediaLibrary.state().get('selection').first().toJSON();
            if (media && media.url) {
                setAttributes({
                    backgroundimage: {
                        imgurl: media.url,
                        imgealt: media.alt || '',
                    },
                });
            }
        });

        mediaLibrary.open();
    }
        return (
            <>
                <InspectorControls>
                    <PanelBody title={stringData.image_title_block}>
                        <TextControl
                            label={stringData.image_title}
                            value={attributes.sectionTitle}
                            onChange={(newTitle) => setAttributes({ sectionTitle: newTitle })}
                        />
                        <h3>{stringData.backgrounimage}</h3>
                        {backgroundimage && backgroundimage.imgurl && (
                            <img src={backgroundimage.imgurl} alt={backgroundimage.imgealt} className="mb-3" />
                        )}
                        <button onClick={openMediaLibrarybackground} className="button button-secondary">
                            {stringData.Select_an_image}
                        </button>   
                    </PanelBody>
                </InspectorControls>
                {attributes.sectionTitle && (
                    <div class="web-heading heading-divider">
                        <h2>{attributes.sectionTitle}</h2> 
                    </div>
                )}
    
                {backgroundimage && backgroundimage.imgurl && (
                    <div class="structure-block">
                        <img src={backgroundimage.imgurl} alt={backgroundimage.imgealt} />
                        <div class="block-link d-lg-none">
                            <div class="block-link-row">
                                <a href={backgroundimage.imgurl} target="_blank" class="d-flex">
                                    <div class="block-link-inner d-flex align-items-center">
                                        <div class="link-content d-flex align-items-center justify-content-between">
                                            <div class="content">
                                                <p>{stringData.Zobacz}</p>
                                            </div>
                                            <div class="right-icon">
                                                <img src={right} alt="structure" />
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>	
                    </div>
                )}
            </>
        );
}



