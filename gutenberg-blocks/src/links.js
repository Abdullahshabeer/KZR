
const { MediaUpload,RichText } = wp.editor;
const { registerBlockType }    = wp.blocks;
const { InspectorControls }    = wp.editor;
const { Button,PanelBody,TextControl }     = wp.components;
const stringData               = myBlockData.strings;
const urlimage                 = myBlockData.defaultimge;
const right                 = myBlockData.right;
const file_icon                 = myBlockData.icontsvg;
registerBlockType('kzrsnamespace/links', {
    title: stringData.link,
    icon: 'smiley',
    category: 'my-custom-category',
    attributes: {
        
		slideritems: {
            type: 'array',
            default: [
				{
					imgeurl:  file_icon,
                    svgContent: '<svg xmlns="http://www.w3.org/2000/svg" width="72" height="73" viewBox="0 0 72 73" fill="none"><path d="M39.6748 4.97754H26.1037C19.9694 4.97754 16.9022 4.97754 14.9965 6.9097C13.0908 8.84187 13.0908 11.9516 13.0908 18.1712V51.1553C13.0908 57.3748 13.0908 60.4846 14.9965 62.4168C16.9022 64.3489 19.9694 64.3489 26.1037 64.3489H45.6231C51.7574 64.3489 54.8246 64.3489 56.7303 62.4168C58.636 60.4846 58.636 57.3748 58.636 51.1553V24.2021C58.636 22.8539 58.636 22.1797 58.3884 21.5736C58.1407 20.9674 57.6706 20.4908 56.7303 19.5374L44.2756 6.9097C43.3353 5.95636 42.8651 5.47969 42.2673 5.22862C41.6694 4.97754 41.0046 4.97754 39.6748 4.97754Z" stroke="#2F3E45" stroke-width="3"/><path class="hover-effect" d="M28.6362 35.3936L46.6362 35.3936" stroke="#2F3E45" stroke-width="3" stroke-linecap="round"/><path class="hover-effect" d="M28.6362 47.5605L40.6362 47.5605" stroke="#2F3E45" stroke-width="3" stroke-linecap="round"/><path d="M40.6367 4.97754V17.1442C40.6367 20.0119 40.6367 21.4458 41.5154 22.3367C42.3941 23.2275 43.8083 23.2275 46.6367 23.2275H58.6367" stroke="#2F3E45" stroke-width="3"/></svg>',
                    imgealt: '',
					title: 'UDB Production environment',
					link: '',
                    filesize: '', 
                    fileextension: '',   
				  },
			],
        },
       
    },
    edit: ImageRepeaterBlockEdit,
    save: function ({ attributes }) {
        const { slideritems } = attributes;
        return (
            <>
        <div class="block-link">
            {slideritems.map((item, index) => ( 
                <div class="block-link-row">
                   <a href={item.link} class="d-flex">
                        <div class="block-link-inner d-flex align-items-center">
                            
                        {item.imgeurl.endsWith('.svg') &&  <div class="icon">
                            <img class="svg" src={item.imgeurl} alt={item.imgealt || 'Image'} />
                            </div>} 
                            <div class="link-content d-flex align-items-center justify-content-between">
                                <div class="content">
                                <p>{item.title} { item.filesize && <span> [{item.filesize}, {item.fileextension}] </span> } </p>
                                </div>
                                <div class="right-icon">
                                <img src={right} alt="icon" aria-hidden="true" />
                                </div>
                            </div>
                        </div>
                    </a>
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
            imgeurl:  file_icon,
            svgContent: '<svg xmlns="http://www.w3.org/2000/svg" width="72" height="73" viewBox="0 0 72 73" fill="none"><path d="M39.6748 4.97754H26.1037C19.9694 4.97754 16.9022 4.97754 14.9965 6.9097C13.0908 8.84187 13.0908 11.9516 13.0908 18.1712V51.1553C13.0908 57.3748 13.0908 60.4846 14.9965 62.4168C16.9022 64.3489 19.9694 64.3489 26.1037 64.3489H45.6231C51.7574 64.3489 54.8246 64.3489 56.7303 62.4168C58.636 60.4846 58.636 57.3748 58.636 51.1553V24.2021C58.636 22.8539 58.636 22.1797 58.3884 21.5736C58.1407 20.9674 57.6706 20.4908 56.7303 19.5374L44.2756 6.9097C43.3353 5.95636 42.8651 5.47969 42.2673 5.22862C41.6694 4.97754 41.0046 4.97754 39.6748 4.97754Z" stroke="#2F3E45" stroke-width="3"/><path class="hover-effect" d="M28.6362 35.3936L46.6362 35.3936" stroke="#2F3E45" stroke-width="3" stroke-linecap="round"/><path class="hover-effect" d="M28.6362 47.5605L40.6362 47.5605" stroke="#2F3E45" stroke-width="3" stroke-linecap="round"/><path d="M40.6367 4.97754V17.1442C40.6367 20.0119 40.6367 21.4458 41.5154 22.3367C42.3941 23.2275 43.8083 23.2275 46.6367 23.2275H58.6367" stroke="#2F3E45" stroke-width="3"/></svg>',
            imgealt: '',
            title: 'UDB Production environment',
            link: '',
            filesize: '', 
            fileextension: '',   
        }] });
    }

    function addItemSec() {
        const newItem = {
            imgeurl:  file_icon,
            svgContent: '<svg xmlns="http://www.w3.org/2000/svg" width="72" height="73" viewBox="0 0 72 73" fill="none"><path d="M39.6748 4.97754H26.1037C19.9694 4.97754 16.9022 4.97754 14.9965 6.9097C13.0908 8.84187 13.0908 11.9516 13.0908 18.1712V51.1553C13.0908 57.3748 13.0908 60.4846 14.9965 62.4168C16.9022 64.3489 19.9694 64.3489 26.1037 64.3489H45.6231C51.7574 64.3489 54.8246 64.3489 56.7303 62.4168C58.636 60.4846 58.636 57.3748 58.636 51.1553V24.2021C58.636 22.8539 58.636 22.1797 58.3884 21.5736C58.1407 20.9674 57.6706 20.4908 56.7303 19.5374L44.2756 6.9097C43.3353 5.95636 42.8651 5.47969 42.2673 5.22862C41.6694 4.97754 41.0046 4.97754 39.6748 4.97754Z" stroke="#2F3E45" stroke-width="3"/><path class="hover-effect" d="M28.6362 35.3936L46.6362 35.3936" stroke="#2F3E45" stroke-width="3" stroke-linecap="round"/><path class="hover-effect" d="M28.6362 47.5605L40.6362 47.5605" stroke="#2F3E45" stroke-width="3" stroke-linecap="round"/><path d="M40.6367 4.97754V17.1442C40.6367 20.0119 40.6367 21.4458 41.5154 22.3367C42.3941 23.2275 43.8083 23.2275 46.6367 23.2275H58.6367" stroke="#2F3E45" stroke-width="3"/></svg>',
            imgealt: '',
            title: 'UDB Production environment',
            link: '',
            filesize: '', 
            fileextension: '',           
            
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
            title: 'Select SVG Image',
            library: {
                type: 'image', // Restrict to images
            },
            button: {
                text: 'Select SVG', // Button label text
            },
            multiple: false, // Only allow single file selection
        });
    
        mediaLibrary.on('select', function () {
            const media = mediaLibrary.state().get('selection').first().toJSON();
            if (media && media.url && media.url.endsWith('.svg')) {
                updateSliderItem(index, 'imgeurl', media.url);
                updateSliderItem(index, 'imgealt', media.alt);
                
            } else {
                alert('Please select an SVG file.');
            }
        });
    
        mediaLibrary.open();
    }
    function openMediaLibrary(index) {
        const mediaLibrary = wp.media({
            title: 'Select Image',
            multiple: false,
        });

        mediaLibrary.on('select', function () {
            const media = mediaLibrary.state().get('selection').first().toJSON();
            if (media && media.url) {
                const url = media.url;
                const filesize = media.filesizeHumanReadable; // Get filesize if available
                const fileExtension = url.split('.').pop();
                updateSliderItem(index, 'link', url); // Update the link
                updateSliderItem(index, 'filesize', filesize); // Update the file size
                 updateSliderItem(index, 'fileextension', fileExtension); // Update the file extension
                
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
                        <h3>{stringData.link} {index + 1}</h3>
                        {item.imgeurl && <img src={item.imgeurl} alt="Image 1" className="mb-3" />}
                        <div className="blockbutton">
                         <button onClick={() => openMediaLibrarysecond(index)} className="button button-secondary">{stringData.link_icon}</button>
                        </div>
                        <TextControl
                            label={stringData.link_content}
                            placeholder={stringData.Enter_a_title}
                            value={item.title}
                            onChange={(value) => updateSliderItem(index, 'title', value)}
                        />
                        <TextControl
                            label={stringData.link_url}
                            placeholder={stringData.Enter_a_title}
                            value={item.link}
                            onChange={(value) => updateSliderItem(index, 'link', value)}
                        />
                        
                        <div className="blockbutton">
                          <button onClick={() => openMediaLibrary(index)} className="button button-secondary">{stringData.choose_file}</button>
                        </div>
                        
                        <button onClick={() => removeSliderItem(index)} className="button button-danger">{stringData.remove_link}</button>
                    </div>
                ))}
                <button onClick={addItemSec} className="button button-primary">{stringData.add_link}</button>
                
            </PanelBody>
        </InspectorControls> 
        <div class="block-link">
            {slideritems.map((item, index) => ( 
                <div class="block-link-row">
                   
                        <div class="block-link-inner d-flex align-items-center">
                            
                        {item.imgeurl.endsWith('.svg') &&
                        <div class="icon">
                            <img class="svg" src={item.imgeurl} alt={item.imgealt || 'Image'} />
                            </div>
                            }
                            
                            <div class="link-content d-flex align-items-center justify-content-between">
                                <div class="content">
                                    <p> {item.title} { item.filesize && <span> [{item.filesize}, {item.fileextension}] </span>} </p>
                                </div>
                                <div class="right-icon">
                                <img src={right} alt="icon" aria-hidden="true" />
                                </div>
                            </div>
                        </div>
                    
                </div>
            ))}    
        </div>
	</>         
    );
}

