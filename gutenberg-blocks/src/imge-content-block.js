const { MediaUpload, RichText } = wp.editor;
const { registerBlockType } = wp.blocks;
const { InspectorControls, InnerBlocks } = wp.editor;
const { Button, PanelBody, TextControl, SelectControl, CheckboxControl, TextareaControl } = wp.components;
const stringData = myBlockData.strings;
const urlimage = myBlockData.defaultimge;

registerBlockType('giosnamespace/img-content-block', {
    title: stringData.image_section_block,
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
                <>
                {item.sectionTitle && (
                <div className={item.upcomingchecbox ? "web-heading heading-divider" : "web-heading"}>
                  <h2>{item.sectionTitle}</h2>
                </div>
                )} 
                <div class="block-with-image">
                    <div class="row custom-space"> 
                        {item.content && 
                         <div class="col-xxl-9 col-xl-8">
                            {/* <p dangerouslySetInnerHTML={{ __html: item.content }}></p> */}
                            <RichText.Content
                                tagName="p"
                                value={item.content}
                            />
                         </div>
                        }
                        {item.imgeurl && (
                         <div class="col-xxl-3 col-xl-4">
                            <div class="block-img">
                                <img src={item.imgeurl} alt={item.imgealt} />
                            </div>
                         </div>
                        )}  
                    </div>
                </div>
            </>
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
            imgeurl: urlimage,
            background:'white',
            position:'right',
            selectheading: 'h2',
            
        }] });
    }

    function addItem(index) {
        const newItem = {
            sectionTitle: 'Czym się zajmujemy',
            imgealt: '',
            upcomingchecbox: false,
            content: 'System KZR INiG jest to globalny system certyfikacji, którego właścicielem jest INiG-PIB.',
            imgeurl: urlimage,
            background:'white',
            position:'right',
            selectheading: 'h2',
        };
        return newItem;
    }
    function openMediaLibrary(index) {
        const mediaLibrary = wp.media({
            title: stringData.Select_an_image,
            multiple: false,
        });

        mediaLibrary.on('select', function () {
            const media = mediaLibrary.state().get('selection').first().toJSON();
            if (media && media.url) {
                updateItem(index, 'imgeurl', media.url);
                updateItem(index, 'imgealt', media.alt);
            }
        });

        mediaLibrary.open();
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
                            <RichText
                                tagName="p"
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
                            
                            {item.imgeurl && (
                                <>
                                    <img src={item.imgeurl} alt="Image 1" className="mb-3" />
                                    <button onClick={() => updateItem(index, 'imgeurl', '')} className="button button-danger">
                                        {stringData.Informacja_Delete_Image}
                                    </button>
                                </>
                            )}
                            
                            <button onClick={() => openMediaLibrary(index)} className="button button-secondary">{stringData.Informacja_Select_an_image}</button>
                            
                            
                        </div>
                    ))}
                    
                </PanelBody>
            </InspectorControls>
            {items.map((item, index) => (
               <>
               {item.sectionTitle && (
               <div className={item.upcomingchecbox ? "web-heading heading-divider" : "web-heading"}>
                 <h2>{item.sectionTitle}</h2>
               </div>
               )} 
               <div className="block-with-image" style={{ background: item.background }}>
               <div className="row custom-space" style={item.position === 'left' ? { flexDirection: 'row-reverse' } : {}}>
                       {item.content && 
                        <div class="col-xxl-9 col-xl-8">
                           {/* <p dangerouslySetInnerHTML={{ __html: item.content }}></p> */}
                           <RichText.Content
                                tagName="p"
                                value={item.content}
                            />
                        </div>
                       }
                       {item.imgeurl && (
                        <div class="col-xxl-3 col-xl-4">
                           <div class="block-img">
                               <img src={item.imgeurl} alt={item.imgealt} />
                           </div>
                        </div>
                       )}  
                   </div>
               </div>
           </>
            ))}
           
        </>
    );
}

