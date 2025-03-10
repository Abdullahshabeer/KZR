const { registerBlockType }               = wp.blocks;
const { MediaUpload, InspectorControls , InnerBlocks , RichText}  = wp.editor;
const { Button, PanelBody, TextControl , TextareaControl}               = wp.components;
const stringData                          = myBlockData.strings;
const right                 = myBlockData.right;
const urlimage = myBlockData.defaultimge;
import { useInstanceId } from '@wordpress/compose';

registerBlockType('kzrnamespace/certification-block', {
  title: stringData.certification,        
  icon: 'admin-links',
  category: 'my-custom-category',
  attributes: {
    files: {
      type: 'array',
      default: [],
    },
  },
   
  edit: CustomBlockEdit,
  save: function ({ attributes }) {
    const { files } = attributes;
    
    return (
        <>
         <div class="accordion-block style-2">
                <div class="accordion" id="accordion-block"> 
                    {files.map((file, parentIndex) => (
                    
                      <div class="accordion-item">
                        
                          <button className={`accordion-button  ${parentIndex === 0 ? '' : 'collapsed'}`} type="button" data-bs-toggle="collapse" data-bs-target={`#collapse-id-${file.uniqueid}`}  aria-expanded="true" aria-controls={`collapse-id-${file.uniqueid}`} >
                          <h2>{file.sectiontitle}</h2>
                              
                              {file.logourl && (
                                <div class="image">
                                  <img src={file.logourl} alt={file.logoalt || "Image"} aria-hidden="true" />
                              </div>
                                )}
                              
                          </button>
                          <div id={`collapse-id-${file.uniqueid}`} className={`accordion-collapse collapse ${parentIndex === 0 ? 'show' : ''} `} data-bs-parent="#accordion-block">
                              <div class="accordion-body">
                              {/* <div dangerouslySetInnerHTML={{ __html: file.sectioncontent }}></div> */}
                                <RichText.Content
                                    tagName="p"
                                    value={file.sectioncontent}
                                />
                                
                              {/* <p dangerouslySetInnerHTML={{ __html: file.sectioncontent }}></p> */}
                                  <div class="block-link style-2">
                                      <div class="block-link-row">
                                      <a href={file.Thumbnail_link} className="d-flex">
                                        {file.Thumbnailurl && (
                                          <>
                                            <div className="icon">
                                              <img src={file.Thumbnailurl} alt={file.Thumbnailalt || "Image"} aria-hidden="true" />
                                            </div>
                                            <div className="block-link-inner d-flex align-items-center">
                                              <div className="link-content d-flex align-items-center justify-content-between">
                                                <div className="content">
                                                  {file.Thumbnail_title && <span>{file.Thumbnail_title}</span>}
                                                  {file.Thumbnail_secondtitle && <p>{file.Thumbnail_secondtitle}</p>}
                                                </div>
                                                <div className="right-icon">
                                                  <img src={right} alt="icon" aria-hidden="true" />
                                                </div>
                                              </div>
                                            </div>
                                          </>
                                        )}
                                      </a>
                                      </div>
                                  </div>    
                              </div>
                          </div>
                      </div>
                      
                  
                ))}
              </div>
            </div>
      </>
    );
  },
});

const { useState } = wp.element;

function CustomBlockEdit(props) {
  const { attributes, setAttributes } = props;
    const { files } = attributes;
    const instanceId = useInstanceId(CustomBlockEdit);

    const addSection = () => {
        const newUniqueId = `unique-id-${instanceId}-${Date.now()}`;
        setAttributes({
            files: [
                ...files,
                {
                    sectiontitle: 'Baltic Control Certification A/S, Brunbjergvej 3, 1, 8240 Risskov',
                    logourl: '',
                    logoalt: '',
                    sectioncontent: '',
                    Thumbnailurl: urlimage,
                    Thumbnailalt: '',
                    Thumbnail_title: 'Certyfikat',
                    Thumbnail_secondtitle:'Bureau Veritas Polska Sp. z o. o.',
                    Thumbnail_link:'',
                    uniqueid: newUniqueId,
                },
            ],
        });
    };

    const removeSection = (parentIndex) => {
        const newFiles = [...files];
        newFiles.splice(parentIndex, 1);
        setAttributes({ files: newFiles });
    };

    const updateItem = (index, key, value) => {
        const newFiles = [...files];
        newFiles[index][key] = value;
        setAttributes({ files: newFiles });
    };

  
  
    const openMediaLibrary = (index) => {
        const mediaLibrary = wp.media({
            title: stringData.Select_an_image,
            multiple: false,
        });

        mediaLibrary.on('select', function () {
            const media = mediaLibrary.state().get('selection').first().toJSON();
            if (media && media.url) {
                updateItem(index, 'logourl', media.url);
                updateItem(index, 'logoalt', media.alt);
            }
        });

        mediaLibrary.open();
    };
    const openMediaLibraryThumbnail = (index) => {
      const mediaLibrary = wp.media({
          title: stringData.Select_an_image,
          multiple: false,
      });

      mediaLibrary.on('select', function () {
          const media = mediaLibrary.state().get('selection').first().toJSON();
          if (media && media.url) {
              updateItem(index, 'Thumbnailurl', media.url);
              updateItem(index, 'Thumbnailalt', media.alt);
          }
      });

      mediaLibrary.open();
  };


    return (
        <>
            <InspectorControls>
                <PanelBody title={stringData.Accordion_File_Block}>
                    {files.map((file, parentIndex) => (
                        <div key={parentIndex} className="mt-2">
                            <TextControl
                                label={stringData.AccordionTitle}
                                value={file.sectiontitle}
                                onChange={(value) => {
                                    updateItem(parentIndex, 'sectiontitle', value);
                                }}
                            />
                            <h3 className="margintop">{stringData.accordion_logo}</h3>
                            {file.logourl && (
                                <>
                                    <img src={file.logourl} alt={file.logoalt || "Image"} className="mb-3" />
                                    <Button
                                        onClick={() => updateItem(parentIndex, 'logourl', '')}
                                        className="button button-danger"
                                    >
                                        {stringData.Accordion_remove_remove}
                                    </Button>
                                </>
                            )}
                            <Button
                                onClick={() => openMediaLibrary(parentIndex)}
                                className="button button-secondary"
                            >
                                {stringData.Accordion_add_logo}
                            </Button>
                            
                            <RichText
                            tagName="p"
                            label={stringData.accordion_discription}
                            value={file.sectioncontent}
                            onChange={(value) => updateItem(parentIndex, 'sectioncontent', value)} // Correct binding here
                            
                        />
                            
                            <h3 className="margintop">{stringData.accordion_Thumbnail}</h3>
                            {file.Thumbnailurl && (
                                <>
                                    <img src={file.Thumbnailurl} alt={file.Thumbnailalt || "Image"} className="mb-3" />
                                    <Button
                                        onClick={() => updateItem(parentIndex, 'Thumbnailurl', '')}
                                        className="button button-danger"
                                    >
                                        {stringData.remove_Thumbnail}
                                    </Button>
                                </>
                            )}
                            <Button
                                onClick={() => openMediaLibraryThumbnail(parentIndex)}
                                className="button button-secondary"
                            >
                                {stringData.add_Thumbnail}
                            </Button>

                            <TextControl
                                label={stringData.Thumbnail_Title}
                                value={file.Thumbnail_title}
                                onChange={(value) => {
                                    updateItem(parentIndex, 'Thumbnail_title', value);
                                }}
                            />
                            <TextControl
                                label={stringData.Thumbnail_second_Title}
                                value={file.Thumbnail_secondtitle}
                                onChange={(value) => {
                                    updateItem(parentIndex, 'Thumbnail_secondtitle', value);
                                }}
                            />
                            <TextControl
                                label={stringData.Thumbnail_Link}
                                value={file.Thumbnail_link}
                                onChange={(value) => {
                                    updateItem(parentIndex, 'Thumbnail_link', value);
                                }}
                            />

                            <div className="mt-2">
                                <Button
                                    className="button button-danger"
                                    onClick={() => removeSection(parentIndex)}
                                >
                                    {stringData.remove_accordion_sectiont}
                                </Button>
                            </div>
                        </div>
                    ))}
                    <div className="mt-4">
                        <Button onClick={addSection} className="button button-primary">
                            {stringData.add_accordion_sectiont}
                        </Button>
                    </div>
                </PanelBody>
            </InspectorControls>
            <div class="accordion-block style-2">
                <div class="accordion" id="accordion-block"> 
                    {files.map((file, parentIndex) => (
                    
                      <div class="accordion-item">
                        
                          <button className={`accordion-button  ${parentIndex === 0 ? '' : 'collapsed'}`} type="button" data-bs-toggle="collapse" data-bs-target={`#collapse-id-${file.uniqueid}`}  aria-expanded="true" aria-controls={`collapse-id-${file.uniqueid}`} >
                          <h2>{file.sectiontitle}</h2>
                              
                              {file.logourl && (
                                <div class="image">
                                  <img src={file.logourl} alt={file.logoalt || "Image"} aria-hidden="true" />
                              </div>
                                )}
                              
                          </button>
                          <div id={`collapse-id-${file.uniqueid}`} className={`accordion-collapse collapse ${parentIndex === 0 ? 'show' : ''} `} data-bs-parent="#accordion-block">
                              <div class="accordion-body">
                              {/* <div dangerouslySetInnerHTML={{ __html: file.sectioncontent }}></div> */}
                                <RichText.Content
                                    tagName="p"
                                    value={file.sectioncontent}
                                />
                                
                              {/* <p dangerouslySetInnerHTML={{ __html: file.sectioncontent }}></p> */}
                                  <div class="block-link style-2">
                                      <div class="block-link-row">
                                      <a href={file.Thumbnail_link} className="d-flex">
                                        {file.Thumbnailurl && (
                                          <>
                                            <div className="icon">
                                              <img src={file.Thumbnailurl} alt={file.Thumbnailalt || "Image"} aria-hidden="true" />
                                            </div>
                                            <div className="block-link-inner d-flex align-items-center">
                                              <div className="link-content d-flex align-items-center justify-content-between">
                                                <div className="content">
                                                  {file.Thumbnail_title && <span>{file.Thumbnail_title}</span>}
                                                  {file.Thumbnail_secondtitle && <p>{file.Thumbnail_secondtitle}</p>}
                                                </div>
                                                <div className="right-icon">
                                                  <img src={right} alt="icon" aria-hidden="true" />
                                                </div>
                                              </div>
                                            </div>
                                          </>
                                        )}
                                      </a>
                                      </div>
                                  </div>    
                              </div>
                          </div>
                      </div>
                      
                  
                ))}
              </div>
            </div>
           </>         
    );
  }
 