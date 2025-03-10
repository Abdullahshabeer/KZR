const { registerBlockType } = wp.blocks;
const { InspectorControls } = wp.editor;
const { PanelBody, SelectControl,TextControl,CheckboxControl } = wp.components;
const { useSelect } = wp.data;
const siteUrl       = myBlockData.siteUrl;
const kelendarz       = myBlockData.kelendarz_url;
const { useState, useEffect } = wp.element;
const stringData = myBlockData.strings;
const right                 = myBlockData.right;
import ShortcodeContentPreview from './ShortcodeContentPreview'; 



registerBlockType('kzrnamespace/differentdesign', {
    title: stringData.differentdesign_block,
    icon: 'smiley',    
    category: 'my-custom-category',
    attributes: {
        postsectiontitle: {
            type: 'string',
            default: 'Aktualności',
        },
        postperpage: {
            type: 'number', // Set the type to 'number'
            default: 3,     // Default value for the number of posts per page
          },
        postType: {
            type: 'string',
            default: 'select', // Default post type
        }, 

        selectedCategory: {
            type: 'string',
            default: '', // Default category
        },
        categoryOptions: {
            type: 'array',
            default: [], // Initialize as an empty array
        },
        buttontitle: {
            type: 'string',
            default: 'Wszystkie aktualności',
        },
        upcomingchecbox: {
            type: 'boolen',
            default: false,
        },
        buttonlink: {
            type: 'string',
            default: '#',
        },
    },
    edit: ImageRepeaterBlockEdit,
    save: function ({ attributes }) {
        const { postType, selectedCategory,postsectiontitle,buttontitle,buttonlink,postperpage,upcomingchecbox } = attributes;
        return (
           <>
           
                        {attributes.postsectiontitle &&
                            <div class={upcomingchecbox ? "web-heading  heading-divider" : "web-heading text-center"}>
                                <h2>{attributes.postsectiontitle}</h2>
                            </div>
                        }
                        [szkolenia-shortcode post_type="{postType}" posts_per_page="{postperpage}" categories="{selectedCategory}"] 
                        <div class="view-more">
                            <div class="web-btn d-flex">
                            {buttonlink &&  
                                <a href={buttonlink} class="link-btn">
                                    <span>{buttontitle}</span>
                                    <div class="icon">
                                        <img src={right} alt="icon" />
                                    </div>
                                </a>
                            }
                            </div>
                        </div>
                      
            </>
        );
    },
});


function ImageRepeaterBlockEdit(props) {
    const { setAttributes, attributes } = props;
    const { postType, selectedCategory,postsectiontitle,buttontitle,buttonlink,postperpage,upcomingchecbox } = attributes;

    const [categoryOptions, setCategoryOptions] = useState([]);
    const [postTypeOptions, setPostTypeOptions] = useState([]);

    // Function to fetch categories based on taxonomy slug
    const fetchCategories = async (taxonomyslug) => {
        try {
            let response;

            if (taxonomyslug === 'category') {
                response = await fetch(`${siteUrl}/wp-json/wp/v2/categories?per_page=100`);
            } else {
                response = await fetch(`${siteUrl}/wp-json/wp/v2/${taxonomyslug}?per_page=100`);
            }

            if (!response.ok) {
                if (response.status === 404) {
                    setCategoryOptions([]);
                } else {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
            } else {
                const data = await response.json();
                const newCategoryOptions = data.map((category) => ({
                    value: category.id,
                    label: category.name,
                }));
                const categoryOptionsWithDefault = [
                    {
                        value: '',
                        label: stringData.Select_Category ,
                    },
                    ...newCategoryOptions,
                ];
                setCategoryOptions(categoryOptionsWithDefault);
            }
        } catch (error) {
            console.error('Error fetching categories:', error);
        }
    };

    const onCategoryChange = (newCategory) => {
        setAttributes({ selectedCategory: newCategory });
    };

    const onPostTypeChange = async (newPostType) => {
        setAttributes({ postType: newPostType, selectedCategory: '' });
        const taxonomyslug = await getTaxonomySlugForPostType(newPostType);
        fetchCategories(taxonomyslug);
    };

    // Function to get post type options
    const getPostTypeOptions = () => {
        const postTypes = wp.data.select('core').getPostTypes({ per_page: -1 });
        const options = [
            {
                value: '', // Add an empty value for the default option
                label: stringData.Select_Post_Type , // Customize the label for the default option
            },
        ];
    
        if (postTypes && postTypes.length > 0) {
            // console.log(postTypes);
            postTypes.forEach((type) => {
                if (type.slug && type.slug!== 'page' && type.slug!== 'attachment' && type.slug!== 'wp_template'&& type.slug!== 'wp_template_part'&& type.slug!== 'wp_navigation'&& type.slug!== 'wp_block'&& type.slug!== 'nav_menu_item') {
                options.push({
                    value: type.slug,
                    label: type.labels.singular_name,
                });
            }
            });
        }
    
        return options;
    };

    // Function to get the taxonomy slug for a given post type
    const getTaxonomySlugForPostType = async (postTypeSlug) => {
        try {
            const response = await fetch(siteUrl + `/wp-json/wp/v2/types/${postTypeSlug}`);

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const data = await response.json();

            if (data && data.taxonomies) {
                const taxonomySlug = data.taxonomies[0];
                return taxonomySlug;
            }

            return '';
        } catch (error) {
            console.error('Error fetching taxonomy for post type:', error);
            return '';
        }
    };
    const handleChange = (newPerPage) => {
        // Parse the newPerPage value to an integer or set it to 0 if it's not a valid number
        const parsedPerPage = parseInt(newPerPage) || 0;
        setAttributes({ postperpage: parsedPerPage });
       
    };
    // Initialize state when component mounts
    useEffect(() => {
        const initializeState = async () => {
            const options = getPostTypeOptions();
            setPostTypeOptions(options);

            if (postType && postType !== 'select') {
                const taxonomyslug = await getTaxonomySlugForPostType(postType);
                fetchCategories(taxonomyslug);
            }
        };

        initializeState();
    }, []);
    const apiCallback   = siteUrl + '/wp-json/blocks-preview-shortvode/v1/szkolenia-post-shortcode-type';
    return (
       <>
            <InspectorControls>
                <PanelBody>
                    <div className="tab-content" id="pills-tabContent">
                    <TextControl
                        label={stringData.post_section_Title}
                        placeholder={stringData.Enter_a_title}
                        value={postsectiontitle}
                        onChange={(newTitle) => setAttributes({ postsectiontitle: newTitle })}
                    />
                    <div>
                    <CheckboxControl
                        label={stringData.Informacja_headerdivider}
                        checked={upcomingchecbox}
                        onChange={(newChecked) => setAttributes({ upcomingchecbox: newChecked })}
                    />
                    </div>
                    <TextControl
                    label={stringData.post_per_page}
                    value={attributes.postperpage ? attributes.postperpage.toString() : ''}
                    onChange={handleChange}
                />
                        <SelectControl
                            label={stringData.Selectapost_type}
                            value={postType}
                            options={getPostTypeOptions()}
                            onChange={onPostTypeChange}
                        />
                        <SelectControl
                            label={stringData.Select_a_category}
                            value={selectedCategory}
                            options={categoryOptions}
                            onChange={onCategoryChange}
                        />
                         <TextControl
                        label={stringData.BUtton_Title}
                        placeholder={stringData.section_button}
                        value={buttontitle}
                        onChange={(newTitle) => setAttributes({ buttontitle: newTitle })}
                    />
                     <TextControl
                        label={stringData.Button_link}
                        placeholder={stringData.Enter_a_title}
                        value={buttonlink}
                        onChange={(newTitle) => setAttributes({ buttonlink: newTitle })}
                    />
                        
                    </div>
                </PanelBody>
            </InspectorControls>
          
                {attributes.postsectiontitle &&
                    <div class={upcomingchecbox ? "web-heading  heading-divider" : "web-heading text-center"}>
                        <h2>{attributes.postsectiontitle}</h2>
                    </div>
                }
                <ShortcodeContentPreview attributes={attributes} apiCallback={apiCallback}/> 
				<div class="view-more">
					<div class="web-btn d-flex">
                    {buttonlink &&  
						<a href={buttonlink} class="link-btn">
							<span>{buttontitle}</span>
							<div class="icon">
                                  <img src={right} alt="icon" />
							</div>
						</a>
                    }
					</div>
				</div>
			</>
           
        
    );
}


