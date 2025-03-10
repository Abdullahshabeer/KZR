

const { PanelBody, SelectControl, TextControl, CheckboxControl } = wp.components;
const { InspectorControls } = wp.editor;
const stringData = myBlockData.strings;
wp.blocks.registerBlockType('kzrnamespace/heading-bloc', {
    title: stringData.Section_headin,
    icon: 'heading',
    category: 'my-custom-category',
    attributes: {
        
        sectionTitle: {
            type: 'string',
            default: stringData.enter_headingg,
        },
        headings: {
            type: 'string',
            default: '',
        },
        selectheading: {
            type: 'string',
            default: 'h1',
        },
        upcomingchecbox: {
            type: 'boolean',
            default: false,
        },
        content: {
            type: 'string',
            default: '',
        },
    },
    edit: HeadingBlockEdit,
    save: function ({ attributes }) {
      const { headingText, selectheading, sectionTitle,upcomingchecbox,content } = attributes;
      const headingTag = selectheading || 'h1';
      
    
      return (
        <>
        <div className={"web-heading" + (upcomingchecbox ? " heading-divider" : "")}>
            {headingTag !== '' && React.createElement(headingTag, { className: sectionTitle }, sectionTitle)}
        </div>
       
    </>
      );
    },
});



function HeadingBlockEdit(props) {
    const { attributes, setAttributes } = props;
    const { headingText, selectheading, sectionTitle,upcomingchecbox,content } = attributes;
    const headingTag = selectheading || 'h1';
    function updateHeadingText(newText) {
        setAttributes({ headingText: newText });
    }

    return (
        <>
            <InspectorControls>
                <PanelBody>
                    <SelectControl
                        label={stringData.heading_style}
                        value={selectheading}
                        options={[
                            {
                                value: '',
                                label: stringData.heading_style,
                            },
                            {
                                value: 'h1',
                                label: stringData.Heading + '1',
                            },
                            {
                                value: 'h2',
                                label: stringData.Heading +'2',
                            },
                            {
                                value: 'h3',
                                label: stringData.Heading + '3',
                            },
                            {
                              value: 'h4',
                              label: stringData.Heading + '4',
                          },
                          {
                            value: 'h5',
                            label: stringData.Heading +'5',
                        },
                        {
                          value: 'h6',
                          label:  stringData.Heading +'6',
                      },
                        ]}
                        onChange={(newStyle) => setAttributes({ selectheading: newStyle })}
                    />
                    <div className="makeUpYourHeadingBlockTypeName">
                        <TextControl
                            label={stringData.sectiontt}
                            value={sectionTitle}
                            onChange={(newTitle) => setAttributes({ sectionTitle: newTitle })}
                        />
                    </div>
                 <div>
                        <CheckboxControl
                            label= {stringData.headerdivider}
                            checked={upcomingchecbox}
                            onChange={(newChecked) => setAttributes({ upcomingchecbox: newChecked })}
                        />
            
                </div>
               
                    
                </PanelBody>
            </InspectorControls>
            <div className={"web-heading" + (upcomingchecbox ? " heading-divider" : "")}>
                {headingTag !== '' && React.createElement(headingTag, { className: sectionTitle }, sectionTitle)}
            </div>
            
        </>
    );
}
