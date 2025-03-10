import axios from 'axios';

const { registerBlockType } = wp.blocks;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, TextControl } = wp.components;
const { useState, useEffect } = wp.element;
const stringData = myBlockData.strings;

registerBlockType('kzr-namespace/api-table', {
    title: stringData.api_table || 'API Table',
    icon: 'smiley',
    category: 'my-custom-category',
    attributes: {
        token: {
            type: 'string',
            default: '20F14E67A39AC9106893',
        },
    },
    edit: ({ attributes, setAttributes }) => {
        
        return (
            <>
               
                        <TextControl
                            label={stringData.apitoken || 'API Token'}
                            value={attributes.token}
                            onChange={(newToken) => setAttributes({ token: newToken })}
                        />
                  
                
            </>
        );
    },
    save() {
        return null; // Dynamic block, rendered by PHP
    }
});
