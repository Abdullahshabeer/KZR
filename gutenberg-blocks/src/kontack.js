const { MediaUpload, RichText } = wp.editor;
const { registerBlockType } = wp.blocks;
const { InspectorControls, InnerBlocks } = wp.editor;
const { Button, PanelBody, TextControl, SelectControl, CheckboxControl, TextareaControl } = wp.components;
const stringData = myBlockData.strings;
const urlimage = myBlockData.defaultimge;

registerBlockType('kzrnamespace/kontact-block', {
    title: stringData.kontakt_block,
    icon: 'smiley',
    category: 'my-custom-category',
    attributes: {
        items: {
            type: 'array',
            default: [],
        },
       
    },

    edit: ImageRepeaterBlockEdit,

    save: function ({ attributes }) {
        const { items,slideritems, selectdesign,upcomingchecbox } = attributes;
        const {selectheading} =  items;
        const headingTag = selectheading || 'h1';
        return (
        <>
            {items.map((item, index) => (
               <div class="content-with-map light-bg" style={{ background: item.background }}>
                    <div class="row">
                        <div class="col-lg-6">
                            {item.sectionTitle && (
                            <div className={item.upcomingchecbox ? "web-heading heading-divider" : "web-heading"}>
                                <h4>{item.sectionTitle}</h4>
                            </div>
                            )} 
                            {item.content && 
                            
                                <p dangerouslySetInnerHTML={{ __html: item.content }}></p>
                            }
                          <InnerBlocks.Content />
                        </div>
                        {item.imgeurl && (
                            <div class="col-lg-6">
                                <div class="map-sec">
                                    {item.imgeurl}
                                </div>
                            </div>
                            )}  
                    </div>
                </div>
            ))}
        </>
        );
      },
});


function ImageRepeaterBlockEdit(props) {
    const { attributes, setAttributes } = props;
    const { items,selectdesign } = attributes;


    if (props.attributes.items.length === 0) {
        props.setAttributes({
            items: [{ 
            sectionTitle: 'Czym się zajmujemy',
            imgealt: '',
            upcomingchecbox: false,
            content: 'System KZR INiG jest to globalny system certyfikacji, którego właścicielem jest INiG-PIB.',
            imgeurl: '',
            background:'white',
            position:'right',
            selectheading: 'h2',
            
        }] });
    }

    function addItem(index) {
        const newItem = {
            sectionTitle: 'INSTYTUT NAFTY I GAZU – Państwowy Instytut Badawczy',
            imgealt: '',
            upcomingchecbox: false,
            content: '',
            imgeurl: '',
            background:'white',
            position:'right',
            selectheading: 'h2',
        };
        return newItem;
    }
   

    function updateItem(index, key, value) {
        const updatedItems = [...items];
        updatedItems[index][key] = value;
        setAttributes({ items: updatedItems });
    }
    return (
        <>
            <InspectorControls>
                <PanelBody title={stringData.image_block} >
                    {items.map((item, index) => (
                        <div key={index} className="mb-3">
                            <h3>section {index + 1}</h3>
                            <div className="makeUpYourHeadingBlockTypeName">
                                <TextControl
                                    label={stringData.Informacja_sectiont_title}
                                    value={item.sectionTitle}
                                    onChange={(newTitle) => updateItem(index, 'sectionTitle', newTitle)}
                                />
                            </div>
                            <div>
                                <CheckboxControl
                                    label={stringData.Informacja_headerdivider}
                                    checked={item.upcomingchecbox}
                                    onChange={(newChecked) => updateItem(index, 'upcomingchecbox', newChecked)}
                                />
                            </div>
                            <TextareaControl
                                label={stringData.Informacja_Enter_a_description}
                                placeholder={stringData.Enter_a_description}
                                value={item.content}
                                onChange={(value) => updateItem(index, 'content', value)}
                            />
                            <SelectControl
                                label={stringData.image_position}
                                value={item.position}
                                options={[
                                    { value: '', label: stringData.selected_image_position },
                                    { value: 'right', label: 'Prawo' },
                                    { value: 'left', label: 'Lewo' },
                                    
                                ]}
                                onChange={(value) => updateItem(index, 'position', value)}
                            />
                            <SelectControl
                                label={stringData.background}
                                value={item.background}
                                options={[
                                    { value: '', label: stringData.selected_background },
                                    { value: 'white', label: 'białe' },
                                    { value: '#EEF3F6', label: 'jasnoszare' },
                                    
                                ]}
                                onChange={(value) => updateItem(index, 'background', value)}
                            />
                            <TextareaControl
                                label={stringData.mapshortcode}
                                placeholder={stringData.Enter_a_description}
                                value={item.imgeurl}
                                onChange={(value) => updateItem(index, 'imgeurl', value)}
                            />
                           
                            
                            
                        </div>
                    ))}
                    
                </PanelBody>
            </InspectorControls>
            {items.map((item, index) => (
            <div class="content-with-map light-bg" style={{ background: item.background }}>
                <div class="row">
                    <div class="col-lg-6">
                        {item.sectionTitle && (
                        <div className={item.upcomingchecbox ? "web-heading heading-divider" : "web-heading"}>
                            <h4>{item.sectionTitle}</h4>
                        </div>
                        )} 
                        {item.content && 
                            <p dangerouslySetInnerHTML={{ __html: item.content }}></p>
                        }
                        <InnerBlocks />
                    </div>
                    {item.imgeurl && (
                        <div class="col-lg-6">
                            <div class="map-sec">
                                {item.imgeurl}
                            </div>
                        </div>
                        )}  
                </div>
            </div>
            ))}
           
        </>
    );
}

          