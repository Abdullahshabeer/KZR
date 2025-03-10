const { registerBlockType }    = wp.blocks;
const { InspectorControls }    = wp.editor;
const { Button,PanelBody,TextControl,TextareaControl }     = wp.components;
const stringData               = myBlockData.strings;
const urlimage                 = myBlockData.defaultimge;
const iconurl                 = myBlockData.icon;
import { useEffect, useRef } from '@wordpress/element';
import { Editor } from '@tinymce/tinymce-react';
import 'tinymce/skins/ui/oxide/skin.min.css';
import 'tinymce/skins/ui/oxide/content.min.css';

registerBlockType('kzrnamespace/homebanner', {
    title: stringData.list,
    icon: 'smiley',
    category: 'my-custom-category',
    attributes: {
        sectionTitle: {
            type: 'string',
            default: 'KZR INiG',
        },
        bannerdiscription: {
            type: 'string',
            default: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do',
        },
       backgroundimage: {
            type: 'object',
            default: {
                imgurl: urlimage,
                imgealt: ''
            },
        },
        bannervideo: {
            type: 'object',
            default: {
                videourl: urlimage,
                imgealt: ''
            },
        },
        
		slideritems: {
            type: 'array',
            default: [
				{
					imgeurl:  iconurl,
                    svgContent: '<svg width="70" height="70" viewBox="0 0 70 70" fill="none" xmlns="http://www.w3.org/2000/svg"><path class="hover-effect" d="M53.9829 44.0071V59.4071M46.5054 51.8688H61.3552" stroke="#2F3E45" stroke-width="3.29999" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path><path d="M36.0028 31.4688C43.3119 31.4688 49.2371 25.5435 49.2371 18.2344C49.2371 10.9252 43.3119 5 36.0028 5C28.6937 5 22.7686 10.9252 22.7686 18.2344C22.7686 25.5435 28.6937 31.4688 36.0028 31.4688Z" stroke="#2F3E45" stroke-width="3.29999" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path><path d="M43.1303 64.5547H9.53418V57.9375C9.53418 43.3193 21.3845 31.4688 36.0027 31.4688C41.0959 31.4688 45.8531 32.9073 49.8901 35.4002" stroke="#2F3E45" stroke-width="3.29999" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path></svg>' ,
                    imgealt: '',
					title: 'Rejestracja w systemie',
					link: ''
				  },
			],
        },
       
    },
    edit: ImageRepeaterBlockEdit,
    save: function ({ attributes }) {
        const { slideritems, sectionTitle, bannerdiscription, backgroundimage, bannervideo } = attributes
        return (
            <>
                 <section className="home-main" >
                 <video autoPlay muted loop poster={attributes.backgroundimage.imgurl || 'images/home-bg.png'}>
                    <source src={attributes.bannervideo.videourl || 'videos/banner-video.mp4'} type="video/mp4" />  
                </video>
                    <div class="container">
                        <div class="home-top-sec">
                            <div class="content">
                                <div class="web-heading">
                                {attributes.sectionTitle && <h1>{attributes.sectionTitle}</h1> } 
                                </div>
                                {attributes.bannerdiscription && <p dangerouslySetInnerHTML={{ __html: attributes.bannerdiscription }}></p>}
                            </div>
                        </div>
                        {slideritems.length > 0 ? (
                            <div class="shortcuts-sec">
                            <div class="web-heading text-center">
                                <h2>{stringData.Na_skrty}</h2>
                            </div>
                            <div class="owl-carousel owl-theme shortcuts-carousel">
                            {slideritems.map((item, index) => (   
                                <div class="item">
                                    <div class="card-content">
                                        <a href={item.link}>
                                        {item.imgeurl.endsWith('.svg') &&  <div class="icon">
                                            <img class="svg" src={item.imgeurl} alt={item.imgealt || 'Image'} aria-hidden="true" />
                                        </div>} 
                                            {item.title && <p>{item.title}</p> }
                                        </a>
                                    </div>
                                </div>
                            ))}	
                                
                            </div>
                        </div>
                    ) : null}
                        
                    </div>
                </section>
            </>     
        )
      },
})

function ImageRepeaterBlockEdit(props) {

    const { setAttributes, attributes } = props;
    const { slideritems, sectionTitle, bannerdiscription, backgroundimage, bannervideo } = attributes;
    const textareaRef = useRef(null);
   
    function updateSliderItem(index, key, value) {
        const updatedSliderItems = [...slideritems]; // Use a different variable name here
        updatedSliderItems[index][key] = value;
       setAttributes({ slideritems: updatedSliderItems }); // Update the slideritems attribute
    }

    if (props.attributes.slideritems.length === 0) {
        props.setAttributes({ slideritems: [{ 
            imgeurl:  iconurl,
            svgContent:'',
            imgealt: '',
            title: 'Rejestracja w systemie',
            link: ''
        }] });
    }

    function addItemSec() {
        const newItem = {
            imgeurl:  iconurl,
            svgContent: '',
            imgealt: '',
            title: 'Rejestracja w systemie',
            link: ''
            
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

                if (media.url.endsWith('.svg')) {
                    fetch(media.url)
                        .then(response => response.text())
                        .then(svgContent => {
                            updateSliderItem(index, 'svgContent', svgContent);
                        });
                } else {
                    updateSliderItem(index, 'svgContent', '');
                }
           
            }
        });

        mediaLibrary.open();
    }
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
                        imgealt: media.alt || ''
                    }
                });
            }
        });

        mediaLibrary.open();
    }

    function openMediaLibraryvideo() {
        const mediaLibrary = wp.media({
            
            title: 'Select Video',
            library: { type: 'video' },
            multiple: false,
        });

        mediaLibrary.on('select', function () {
            const media = mediaLibrary.state().get('selection').first().toJSON();
            if (media && media.url) {
                setAttributes({
                    bannervideo: {
                        videourl: media.url,
                        imgealt: media.alt || ''
                    }
                });
            }
        });

        mediaLibrary.open();
    }
    
   
    return (

        <>
         <InspectorControls>
            <PanelBody title={stringData.Kontakt_home_block}>
                <TextControl
                    label={stringData.banner_title}
                    value={attributes.sectionTitle}
                    onChange={(newTitle) => setAttributes({ sectionTitle: newTitle })}
                />
                <Editor
                    id="custom-textarea-control"
                    value={attributes.bannerdiscription}
                    ref={textareaRef}
                    init={{
                        height: 300,
                        menubar: false,
                        plugins: [ ],
                        toolbar:
                            'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                        // Additional configuration to mimic TextareaControl styles if needed
                    }}
                    onEditorChange={(innernewTitle) => setAttributes({ bannerdiscription: innernewTitle })}
                />
                     {/* <TextareaControl
                    label={stringData.banner_discription}
                    id="custom-textarea-control"
                    ref={textareaRef}
                    value={attributes.bannerdiscription}
                    onChange={(innernewTitle) => setAttributes({ bannerdiscription: innernewTitle })}
                />  */}

                 <h3>{stringData.backgrounimage} </h3>
                    {attributes.backgroundimage.imgurl && (
                        <img src={attributes.backgroundimage.imgurl} alt={attributes.backgroundimage.imgealt} className="mb-3" />
                    )}
                    <button onClick={openMediaLibrarybackground} className="button button-secondary">
                        {stringData.Select_an_image}
                    </button>
                    
                    <TextControl
                        label={stringData.bannervideo}
                        value={bannervideo.videourl}
                        onChange={(newVideoUrl) => setAttributes({
                            bannervideo: {
                                ...bannervideo,
                                videourl: newVideoUrl
                            }
                        })}
                    />
                    <Button onClick={openMediaLibraryvideo} className="button button-secondary">
                        {stringData.select_video}
                    </Button>
                {slideritems.map((item, index) => (
                    <div key={index} className="mb-3">
                        <h3>{stringData.shortcut} {index + 1}</h3>
                        {item.imgeurl && <img src={item.imgeurl} alt="Image 1" className="mb-3" />}
                        <button onClick={() => openMediaLibrarysecond(index)} className="button button-secondary">{stringData.shorticon}</button>
                        <TextControl
                            label={stringData.shortcuttitle}
                            placeholder={stringData.Enter_a_title}
                            value={item.title}
                            onChange={(value) => updateSliderItem(index, 'title', value)}
                        />
                         <TextControl
                            label={stringData.shortcutlink}
                            placeholder={stringData.Enter_a_link}
                            value={item.link}
                            onChange={(value) => updateSliderItem(index, 'link', value)}
                        />
                        <button onClick={() => removeSliderItem(index)} className="button button-danger">{stringData.list_remove}</button>
                    </div>
                ))}
                <button onClick={addItemSec} className="button button-primary">{stringData.list_add_iteme}</button>
                
            </PanelBody>
        </InspectorControls> 
        <section className="home-main" >
		<video autoPlay muted loop poster={attributes.backgroundimage.imgurl || 'images/home-bg.png'}>
            <source src={attributes.bannervideo.videourl || 'videos/banner-video.mp4'} type="video/mp4" />  
        </video>
        <div class="container">
			<div class="home-top-sec">
				<div class="content">
					<div class="web-heading">
                    {attributes.sectionTitle && <h1>{attributes.sectionTitle}</h1> } 
					</div>
					{attributes.bannerdiscription && <p dangerouslySetInnerHTML={{ __html: attributes.bannerdiscription }}></p>}
				</div>
			</div>
            {slideritems.length > 0 ? (
                <div class="shortcuts-sec">
				<div class="web-heading text-center">
					<h2>{stringData.Na_skrty}</h2>
				</div>
				<div class="owl-carousel owl-theme shortcuts-carousel">
                {slideritems.map((item, index) => (   
				    <div class="item">
				    	<div class="card-content">
							<a href={item.link}>
                                 {item.imgeurl.endsWith('.svg') &&  <div class="icon">
                                     <img class="svg" src={item.imgeurl} alt={item.imgealt || 'Image'} aria-hidden="true" />
                                </div>} 
								
								{item.title && <p>{item.title}</p> }
							</a>
						</div>
				    </div>
                ))};	
					
				</div>
			</div>
          ) : null}
			
		</div>
	</section>
	</>         
    );
}


