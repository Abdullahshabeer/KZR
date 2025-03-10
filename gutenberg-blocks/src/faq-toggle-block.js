const { registerBlockType }               = wp.blocks;
const { MediaUpload, InspectorControls , InnerBlocks }  = wp.editor;
const { Button, PanelBody, TextControl , TextareaControl}               = wp.components;
const stringData    = myBlockData.strings;
import { useInstanceId } from '@wordpress/compose';

registerBlockType('kzrnamespace/accordion-block', {
  title: stringData.accordion,
  icon: 'smiley',
  category: 'my-custom-category',
  attributes: {
    sectiontitle:{
        type:'string',
        default:'FAQ',

    },
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
        {attributes.sectionTitle && (
                <div class="web-heading heading-divider">
                    <h2>{attributes.sectionTitle}</h2> 
                </div>
            )}
            <div class="accordion-block">
                <div class="accordion" id="accordion-block">
                    {files.map((file, parentIndex) => {
                        return (
                        <div className="accordion-item" key={parentIndex}>
                             <button
                                className={`accordion-button  ${parentIndex === 0 ? '' : 'collapsed'}`}
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target={`#collapse-id-${file.uniqueid}`}
                                aria-expanded="true"
                                aria-controls={`collapse-id-${file.uniqueid}`}
                            >{file.sectiontitle}</button>
                            <div
                                id={`collapse-id-${file.uniqueid}`}
                                className={`accordion-collapse collapse ${parentIndex === 0 ? 'show' : ''} `}
                                data-bs-parent="#accordion-block"
                                >
                                <div class="accordion-body">
                                {file.sectioncontent && <p dangerouslySetInnerHTML={{ __html: file.sectioncontent }}></p>}
                                </div>
                            </div>
                        </div>
                        );
                    })}
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
          sectiontitle: '1. Jaki jest czas uzyskania Certyfikatu w Systemie KZR INiG?',
          sectioncontent:
            'Gospodarstwo rolne, nie objęte systemem płatności w ramach zasady wzajemnej zgodności, <b>może produkować biomasę <br>spełniająca KZR</b>, jeśli określone kryteria zrównoważonego rozwoju są spełnione (kryteria dotyczące gruntów). Jest to<br> weryfikowane podczas audytu.',
          
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

      return (
        <>
          <InspectorControls>
            <PanelBody title={stringData.Accordion_File_Block}>
            <TextControl
                label={stringData.faq_section_title}
                value={attributes.sectionTitle}
                onChange={(newTitle) => setAttributes({ sectionTitle: newTitle })}
            />
              {files.map((file, parentIndex) => (
                <div key={parentIndex} className="mt-2">
                  <h3>{stringData.faq_title}</h3>
                  <input
                    type="text"
                    placeholder={stringData.fa_title}
                    className="form-control"
                    value={file.sectiontitle}
                    onChange={(e) => {
                      const newFiles = [...files];
                      newFiles[parentIndex].sectiontitle = e.target.value;
                      setAttributes({ files: newFiles });
                    }}
                  />
                  <h3 className="margintop">{stringData.Enter_a_description}</h3>
                  <textarea
                    placeholder={stringData.Enter_description}
                    value={file.sectioncontent}
                    className="form-control"
                    rows={10} // Set the number of rows to 20
                    onChange={(e) => {
                      const newFiles = [...files];
                      newFiles[parentIndex].sectioncontent = e.target.value;
                      setAttributes({ files: newFiles });
                    }}
                  ></textarea>
                  <div className="mt-2">
                    <Button className="button button-danger" onClick={() => removeSection(parentIndex)}>
                      {stringData.Delete_a_section}
                    </Button>
                  </div>
                </div>
              ))}
              <div className="mt-4">
                <Button onClick={addSection} className="button button-primary">
                  {stringData.add_sectiont}
                </Button>
              </div>
            </PanelBody>
          </InspectorControls>
          {attributes.sectionTitle && (
                <div class="web-heading heading-divider">
                    <h2>{attributes.sectionTitle}</h2> 
                </div>
            )}
            <div class="accordion-block">
                <div class="accordion" id="accordion-block">
                    {files.map((file, parentIndex) => {
                        return (
                        <div className="accordion-item" key={parentIndex}>
                             <button
                                className={`accordion-button  ${parentIndex === 0 ? '' : 'collapsed'}`}
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target={`#collapse-id-${file.uniqueid}`}
                                aria-expanded="true"
                                aria-controls={`collapse-id-${file.uniqueid}`}
                            >{file.sectiontitle}</button>
                            <div
                                id={`collapse-id-${file.uniqueid}`}
                                className={`accordion-collapse collapse ${parentIndex === 0 ? 'show' : ''} `}
                                data-bs-parent="#accordion-block"
                                >
                                <div class="accordion-body">
                                {file.sectioncontent && <p dangerouslySetInnerHTML={{ __html: file.sectioncontent }}></p>}
                                </div>
                            </div>
                        </div>
                        );
                    })}
                </div>
            </div>
      </>
    );
  }


           