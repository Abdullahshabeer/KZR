
const { MediaUpload,RichText } = wp.editor;
const { registerBlockType }    = wp.blocks;
const { InspectorControls }    = wp.editor;
const { Button,PanelBody,TextControl }     = wp.components;
const stringData               = myBlockData.strings;
const urlimage                 = myBlockData.defaultimge;

registerBlockType('kzrnamespace/kodkr', {
    title: stringData.kodzakres,
    icon: 'smiley',
    category: 'my-custom-category',
    attributes: {
        
		slideritems: {
            type: 'array',
            default: [
				{
					title: 'PO',
					discription: 'Miejsce pochodzenia',
					
				  },
			],
        },
       
    },
    edit: ImageRepeaterBlockEdit,
    save: function ({ attributes }) {
        const { slideritems , sectionTitle, Titlecontent, mapshortcode,mainTitle } = attributes;
        return (
            <>
            <div class="table-block">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{stringData.defaultkod}</th>
                            <th>{stringData.defaultZakres}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {slideritems.map((item, index) => (  
                            <tr>
                                <td><b>{item.title}</b></td>
                                <td>{item.discription}</td>
                            </tr>
                        ))}   
                        
                    </tbody>
                </table>
            </div>
     </>     
        );
      },
});

function ImageRepeaterBlockEdit(props) {

    const { setAttributes, attributes } = props;
    const { slideritems , sectionTitle, Titlecontent, mapshortcode,mainTitle } = attributes;

   
    function updateSliderItem(index, key, value) {
        const updatedSliderItems = [...slideritems]; // Use a different variable name here
        updatedSliderItems[index][key] = value;
       setAttributes({ slideritems: updatedSliderItems }); // Update the slideritems attribute
    }

    if (props.attributes.slideritems.length === 0) {
        props.setAttributes({ slideritems: [{ 
            title: 'PO',
            discription: 'Miejsce pochodzenia',
        }] });
    }

    function addItemSec() {
        const newItem = {
            title: 'PO',
            discription: 'Miejsce pochodzenia',
            
        };
       setAttributes({ slideritems: [...slideritems, newItem] }); 
    }

   

    function removeSliderItem(index) {
        const updatedSliderItems = [...slideritems];
        updatedSliderItems.splice(index, 1);
       setAttributes({ slideritems: updatedSliderItems });
    }
    return (

        <>
         <InspectorControls>
            <PanelBody title={stringData.Kontakt_home_block}>
                {slideritems.map((item, index) => (
                    <div key={index} className="mb-3">
                        <h3>{stringData.defaultZakres} {index + 1}</h3>
                      
                        <TextControl
                            label={stringData.Kod}
                            placeholder={stringData.Enter_a_title}
                            value={item.title}
                            onChange={(value) => updateSliderItem(index, 'title', value)}
                        />
                         <TextControl
                            label={stringData.Zakres}
                            placeholder={stringData.Enter_a_title}
                            value={item.discription}
                            onChange={(value) => updateSliderItem(index, 'discription', value)}
                        />
                        
                        <button onClick={() => removeSliderItem(index)} className="button button-danger">{stringData.remove_Zakres}</button>
                    </div>
                ))}
                <button onClick={addItemSec} className="button button-primary">{stringData.add_Zakres}</button>
                
            </PanelBody>
        </InspectorControls> 
        <div class="table-block">
            <table class="table">
                <thead>
                    <tr>
                        <th>{stringData.defaultkod}</th>
                        <th>{stringData.defaultZakres}</th>
                    </tr>
                </thead>
                <tbody>
                    {slideritems.map((item, index) => (  
                        <tr>
                            <td><b>{item.title}</b></td>
                            <td>{item.discription}</td>
                        </tr>
                    ))}   
                    
                </tbody>
            </table>
        </div>
	</>         
    );
}