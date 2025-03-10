const { MediaUpload, RichText, InspectorControls } = wp.blockEditor;
const { registerBlockType } = wp.blocks;
const { Button, PanelBody, TextControl, SelectControl, TextareaControl } = wp.components;
const stringData = myBlockData.strings;
const urlimage = myBlockData.defaultimge;

registerBlockType('kzrnamespace/scopcertification', {
    title: stringData.scop_certifaction,
    icon: 'smiley',
    category: 'my-custom-category',
    attributes: {
        size: {
            type: 'string',
            default: '3',
        },
        items: {
            type: 'array',
            default: [
                {
                    link: '',
                    imgeurl: urlimage,
                    imgealt: '',
                    svgContent: '', // Add svgContent to attributes
                    title: 'Biopaliwa i biopłyny',
                    discription: ''
                },
            ],
        },
       
    },
    edit: ImageRepeaterBlockEdit,
    save: function ({ attributes }) {
        const { items, size,  } = attributes;
        return (
        <div className="cards-wrap">
            <div className="row custom-space">
                {items.map((item, index) => (
                    <div key={index} className={`col-xl-${size} col-md-6`}>
                        <div className="web-card light-bg border-radius">
                            <a href={item.link}>
                                {item.imgeurl && item.imgeurl.endsWith('.svg') ? (
                                        ''
                                    ) : (
                                        <div className="article-featured-img">
                                            {item.imgeurl && <img src={item.imgeurl} alt={item.imgealt} />}
                                        </div>
                                    )}
                                <div className="content text-center">
                                      {item.imgeurl && item.imgeurl.endsWith('.svg') ? (
                                            <div class="icon">
                                                <img class="svg" src={item.imgeurl} alt={item.imgealt || 'Image'} />
                                             </div>
                                    ) : (
                                        ''
                                    )}
                                    {item.title && (
                                        <div className="web-heading">
                                            <h4>{item.title}</h4>
                                        </div>
                                    )}
                                    {item.discription && (
                                        <p dangerouslySetInnerHTML={{ __html: item.discription }}></p>
                                    )}
                                </div>
                            </a>
                        </div>
                    </div>
                ))}
            </div>
        </div>
        );
    },
});

function ImageRepeaterBlockEdit(props) {
    const { setAttributes, attributes } = props;
    const { items, size } = attributes;

    function updateSliderItem(index, key, value) {
        const updateditems = [...items];
        updateditems[index][key] = value;
        setAttributes({ items: updateditems });
    }

    if (items.length === 0) {
        setAttributes({
            items: [{
            link: '',
            imgeurl: urlimage,
            imgealt: '',
            svgContent: '', // Add svgContent to attributes
            title: 'Biopaliwa i biopłyny',
            discription: ''
            }]
        });
    }

    function addItemSec() {
        const newItem = {
            link: '',
            imgeurl: urlimage,
            imgealt: '',
            svgContent: '', // Add svgContent to attributes
            title: 'Biopaliwa i biopłyny',
            discription: ''
        };
        setAttributes({ items: [...items, newItem] });
    }

    function removeSliderItem(index) {
        const updateditems = [...items];
        updateditems.splice(index, 1);
        setAttributes({ items: updateditems });
    }

    function openMediaLibrarysecond(index) {
        const mediaLibrary = wp.media({
            title: 'Select Image',
            multiple: false,
        });

        mediaLibrary.on('select', function () {
            const media = mediaLibrary.state().get('selection').first().toJSON();
            if (media && media.url) {
                updateSliderItem(index, 'imgeurl', media.url);
                updateSliderItem(index, 'imgealt', media.alt);
            }
        });

        mediaLibrary.open();   
    }
    

    return (
        <>
            <InspectorControls>
                <PanelBody title={stringData.Kontakt_home_block}>
                    <SelectControl
                        label={stringData.design_size}
                        value={size}
                        options={[
                            { value: '', label: stringData.selected_design_size },
                            { value: 6, label: 2 },
                            { value: 4, label: 3 },
                            { value: 3, label: 4 },
                        ]}
                        onChange={(newSize) => setAttributes({ size: newSize })}
                    />
                    {items.map((item, index) => (
                        <div key={index} className="mb-3">
                            <h3>{stringData.imageicon} {index + 1}</h3>
                            {item.imgeurl && <img src={item.imgeurl} alt="Image 1" className="mb-3" />}
                            <Button onClick={() => openMediaLibrarysecond(index)} className="button button-secondary">
                                {stringData.addmedia}
                            </Button>
                            <TextControl
                                label={stringData.blocktitle}
                                placeholder={stringData.Enter_a_title}
                                value={item.title}
                                onChange={(value) => updateSliderItem(index, 'title', value)}
                            />
                            <TextareaControl
                                label={stringData.blockdiscription}
                                placeholder={stringData.Enter_a_discription}
                                value={item.discription}
                                onChange={(value) => updateSliderItem(index, 'discription', value)}
                            />
                            <TextControl
                                label={stringData.blocklink}
                                placeholder={stringData.Enter_a_link}
                                value={item.link}
                                onChange={(value) => updateSliderItem(index, 'link', value)}
                            />
                            <Button onClick={() => removeSliderItem(index)} className="button button-danger">
                                {stringData.block_remove}
                            </Button>
                        </div>
                    ))}
                    <Button onClick={addItemSec} className="button button-primary">
                        {stringData.block_add}
                    </Button>
                </PanelBody>
            </InspectorControls>
            <div className="cards-wrap">
                <div className="row custom-space">
                    {items.map((item, index) => (
                        <div key={index} className={`col-xl-${size} col-md-6`}>
                            <div className="web-card light-bg border-radius">
                                    {item.imgeurl && item.imgeurl.endsWith('.svg') ? (
                                            ''
                                        ) : (
                                            <div className="article-featured-img">
                                                {item.imgeurl && <img src={item.imgeurl} alt={item.imgealt} />}
                                            </div>
                                        )}
                                    <div className="content text-center">
                                          {item.imgeurl && item.imgeurl.endsWith('.svg') ? (
                                            <div class="icon">
                                               <img class="svg" src={item.imgeurl} alt={item.imgealt || 'Image'} />
                                            </div>
                                        ) : (
                                            ''
                                        )}
                                        {item.title && (
                                            <div className="web-heading">
                                                <h4>{item.title}</h4>
                                            </div>
                                        )}
                                        {item.discription && (
                                            <p dangerouslySetInnerHTML={{ __html: item.discription }}></p>
                                        )}
                                    </div>
                                
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </>
    );
}
