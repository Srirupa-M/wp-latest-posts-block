import { useBlockProps } from '@wordpress/block-editor';
import { PanelBody, RangeControl, SelectControl, Spinner } from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
import { useEffect, useState } from '@wordpress/element';

export default function Edit({ attributes, setAttributes }) {
    const { numberOfPosts, order, category } = attributes;
    const blockProps = useBlockProps();

    const [posts, setPosts] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        setLoading(true);
        setError(null);

        const queryParams = new URLSearchParams({
            per_page: numberOfPosts,
            order: order,
            _embed: true,
        });

        if (category) {
            queryParams.append('categories', category);
        }

        fetch(`/wp-json/wp/v2/posts?${queryParams.toString()}`)
           .then((res) => {
              if(!res.ok) {
                throw new Error(`HTTP error! Status: ${res.status}`);
              }
              return res.json();
           })
           .then((data) => {
               if(Array.isArray(data)) {
                  setPosts(data);
               } else {
                  setPosts([]);
                  setError('Unexpected API response.');
               }
           })
           .catch((err) => {
                console.error('Fetch error:', err);
                setError('Failed to fetch posts.');
                setPosts([]);
           })
           .finally(() => setLoading(false));
    }, [numberOfPosts, order, category]);

    //Category dropdown
    const categories = useSelect((select) =>
        select('core').getEntityRecords('taxonomy', 'category', { per_page: -1 })
    );

    return (
        <>
           <InspectorControls>
               <PanelBody title="Post Settings" initialOpen={true}>
                   <RangeControl
                       label="Number Of Posts"
                       value={numberOfPosts}
                       onChange={(val) => setAttributes({ numberOfPosts: val })}
                       min={1}
                       max={20}
                   />
                   <SelectControl
                       label="Order"
                       value={order}
                       options={[
                          { label: 'Newest to Oldest', value: 'desc' },
                          { label: 'Oldest to Newest', value: 'asc' },
                       ]}
                       onChange={(val) => setAttributes({ order: val })}
                   />
                   {Array.isArray(categories) ? (
                      <SelectControl
                         label="Category"
                         value={category}
                         options={[
                            { label: 'All Categories', value: ''},
                            ...categories.map((cat) => ({
                                label: cat.name,
                                value: String(cat.id),
                            })),
                         ]}
                         onChange={(val) => setAttributes({ category: val })}
                      />
                        ) : (
                            <p>Loading categories...</p>
                        )}
                </PanelBody>
           </InspectorControls>

           <div {...blockProps}>
               {loading ? (
                   <Spinner />
               ) : error ? (
                   <p style={{ color: 'red' }}>{error}</p>
               ) : posts.length === 0 ? (
                   <p>No Posts Found.</p>
               ) : (
                   <div className="wplpb-posts-grid-editor">
                      {posts.map((post) => {
                        const media = post._embedded?.['wp:featuredmedia']?.[0];
                        const author = post._embedded?.author?.[0];
                        const imageUrl = media?.source_url;

                        return (
                            <div className="wplpb-editor-card" key={post.id}>
                                {imageUrl && (
                                    <div className="wplpb-editor-image">
                                        <img src={imageUrl} alt={post.title.rendered} />
                                    </div>
                                )}
                                <h3
                                   className="wplpb-editor-title"
                                   dangerouslySetInnerHTML={{ __html: post.title.rendered }}
                                />
                                {author?.name && (
                                    <p className="wplpb-editor-author">{author.name}</p>
                                )}
                            </div>
                        );
                      })}
                   </div>
               )}
           </div>
        </>
    );
}