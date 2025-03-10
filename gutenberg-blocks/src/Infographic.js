
const { MediaUpload,RichText } = wp.editor;
const { registerBlockType }    = wp.blocks;
const { InspectorControls }    = wp.editor;
const { Button,PanelBody,TextControl,TextareaControl }     = wp.components;
const stringData               = myBlockData.strings;
const urlimage                 = myBlockData.defaultimge;

registerBlockType('kzrnamespace/graphic', {
    title: stringData.Infographi,
    icon: 'smiley',
    category: 'my-custom-category',
    attributes: {
        
		slideritems: {
            type: 'array',
            default: [
				{
					imgeurl:  urlimage,
                    imgealt: '',
					title: 'KROK 1 Spełnienie wymagań Systemu',
					progressbar: '20',
					backgroundcolor: 'linear-gradient(180deg, #3A494E 0%, #60583F 100%)',
                    discription: 'Aby zostać Uczestnikiem Systemu KZR INiG i uzyskać Certyfikat KZR INiG należy zapoznać się z Dokumentami Systemowymi (link), i w zależności od działalności przedsiębiorstwa oraz miejsca w łańcuchu dostaw, wdrożyć odpowiedni system zarządzania spełniając wymagania Systemu KZR INiG.',
				  },
			],
        },
       
    },
    edit: ImageRepeaterBlockEdit,
    save: function ({ attributes }) {
        const { slideritems , sectionTitle, Titlecontent, mapshortcode,mainTitle } = attributes;
        return (
            <>
     <div class="stages-card-block">
        {slideritems.map((item, index) => (  
            <div class="stage-card-row light-bg">
                <div
                    className="card-img"
                    role="progressbar"
                    style={{
                        '--value': item.progressbar,
                        '--background': item.backgroundcolor,
                    }}
                >
                    {item.imgeurl && <img src={item.imgeurl} alt={item.imgealt} />}
                </div>
                <div class="card-color" style={{background:item.backgroundcolor}}></div>
                <div class="content">
                    <h2>{item.title}</h2>
                    <p dangerouslySetInnerHTML={{ __html: item.discription }}></p>
                </div>
            </div>
        ))}   	
    </div>
     </>     
        );
      },
});

function ImageRepeaterBlockEdit(props) {

    const { setAttributes, attributes } = props;
    const { slideritems  } = attributes;

   
    function updateSliderItem(index, key, value) {
        const updatedSliderItems = [...slideritems]; // Use a different variable name here
        updatedSliderItems[index][key] = value;
       setAttributes({ slideritems: updatedSliderItems }); // Update the slideritems attribute
    }

    if (props.attributes.slideritems.length === 0) {
        props.setAttributes({ slideritems: [{ 
            imgeurl:  urlimage,
            imgealt: '',
            title: 'KROK 1 Spełnienie wymagań Systemu',
            progressbar: '20',
            backgroundcolor: 'linear-gradient(180deg, #3A494E 0%, #60583F 100%)',
            discription: 'Aby zostać Uczestnikiem Systemu KZR INiG i uzyskać Certyfikat KZR INiG należy zapoznać się z Dokumentami Systemowymi (link), i w zależności od działalności przedsiębiorstwa oraz miejsca w łańcuchu dostaw, wdrożyć odpowiedni system zarządzania spełniając wymagania Systemu KZR INiG.',
            }] });
    }

    function addItemSec() {
        const newItem = {
            imgeurl:  urlimage,
            imgealt: '',
            title: 'KROK 1 Spełnienie wymagań Systemu',
            progressbar: '20',
            backgroundcolor: 'linear-gradient(180deg, #3A494E 0%, #60583F 100%)',
            discription: 'Aby zostać Uczestnikiem Systemu KZR INiG i uzyskać Certyfikat KZR INiG należy zapoznać się z Dokumentami Systemowymi (link), i w zależności od działalności przedsiębiorstwa oraz miejsca w łańcuchu dostaw, wdrożyć odpowiedni system zarządzania spełniając wymagania Systemu KZR INiG.',
				  
        };
       setAttributes({ slideritems: [...slideritems, newItem] }); 
    }

   

    function removeSliderItem(index) {
        const updatedSliderItems = [...slideritems];
        updatedSliderItems.splice(index, 1);
       setAttributes({ slideritems: updatedSliderItems });
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
                {slideritems.map((item, index) => (
                    <div key={index} className="mb-3">
                        <h3>{stringData.Infographic} {index + 1}</h3>
                        {item.imgeurl && <img src={item.imgeurl} alt="Image 1" className="mb-3" />}
                        <button onClick={() => openMediaLibrarysecond(index)} className="button button-secondary">{stringData.Infographic_Select_an_image}</button>
                        <TextControl
                            label={stringData.Infographic_title}
                            placeholder={stringData.Enter_a_title}
                            value={item.title}
                            onChange={(value) => updateSliderItem(index, 'title', value)}
                        />
                        <TextareaControl
                            label={stringData.Infographic_discription}
                            placeholder={stringData.Enter_a_title}
                            value={item.discription}
                            onChange={(value) => updateSliderItem(index, 'discription', value)}
                        />
                        <TextControl
                            label={stringData.progressbar}
                            placeholder={stringData.Enter_a_title}
                            value={item.progressbar}
                            onChange={(value) => updateSliderItem(index, 'progressbar', value)}
                        />
                        <TextControl
                            label={stringData.backgroundcolor}
                            placeholder={stringData.Enter_a_title}
                            value={item.backgroundcolor}
                            onChange={(value) => updateSliderItem(index, 'backgroundcolor', value)}
                        /> 
                        <button onClick={() => removeSliderItem(index)} className="button button-danger">{stringData.Infographic_remove}</button>
                    </div>
                ))}
                <button onClick={addItemSec} className="button button-primary">{stringData.Infographic_add}</button>
                
            </PanelBody>
        </InspectorControls> 
        <div class="stages-card-block">
            {slideritems.map((item, index) => (  
                <div class="stage-card-row light-bg">
                    <div
                        className="card-img"
                        role="progressbar"
                        style={{
                            '--value': item.progressbar,
                            '--background': item.backgroundcolor,
                        }}
                    >
                        {item.imgeurl && <img src={item.imgeurl} alt={item.imgealt} />}
                    </div>
                    <div class="card-color" style={{background:item.backgroundcolor}}></div>
                    <div class="content">
                        <h2>{item.title}</h2>
                        <p dangerouslySetInnerHTML={{ __html: item.discription }}></p>
                    </div>
                </div>
            ))}   	
        </div>
	</>         
    );
}
