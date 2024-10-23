import React, { useState } from 'react'
import Note from './Note'
import Favourite from './Favourite'

/**
 * Content List
 * 
 * This sets up the list for the content page so that it is listed in the right order with the correct authors and affiliations, notes, favourites for each piece of content.
 * Also uses On click so relevant information is displayed when clicking on either content title or Authors.
 * 
 * @author Patrick Shaw
 */
function ContentList(props) {
    /**
     * State variable for toggling the visibility of the content description.
     * @type {[boolean, Function]}
     */
    const [visibleDes, setVisibleDes] = useState(false)

    /**
     * State variable for toggling the visibility of the authors' details.
     * @type {[boolean, Function]}
     */
    const [visibleAut, setVisibleAut] = useState(false)

    /**
     * Toggles the visibility of the content description.
     */
    const showDescription = () => setVisibleDes(!visibleDes)

    /**
     * Toggles the visibility of the authors' details.
     */
    const showAuthors = () => setVisibleAut(!visibleAut)

    const relevantAuthors = props.authors.filter(author => author.content_id === props.content.id)

    return (
        <section className="border border-gray-300 p-4 rounded">
            <h3 className="cursor-pointer mb-4 text-lg font-semibold" onClick={showDescription}>
                {props.content.title}
            </h3>
            {visibleDes && (
                <div className="mb-6 bg-white shadow-lg rounded-lg p-4">
                    <p className="mb-2 text-gray-700">{props.content.abstract}</p>
                    <p className="mb-2 text-sm font-medium text-gray-800">Type: {props.content.type}</p>
                    {props.content.award && <p className="mb-2 text-sm font-medium text-gray-800">Accolades: {props.content.award}</p>}
            
                    <p className="mb-2 text-sm font-medium text-gray-800">
                        <span className="font-bold">Link: </span>
                        <a href={props.content.doi_link} target="_blank" rel="noopener noreferrer" className="text-blue-600 hover:text-blue-800 hover:underline">
                            {props.content.doi_link}
                        </a>
                    </p>
            
                    {props.content.preview_video && (
                        <p className="mb-2 text-sm font-medium text-gray-800">
                            <span className="font-bold">Preview: </span>
                            <a href={props.content.preview_video} target="_blank" rel="noopener noreferrer" className="text-blue-600 hover:text-blue-800 hover:underline">
                                {props.content.preview_video}
                            </a>
                        </p>
                    )}
                    {props.signedIn && 
                    <Note 
                    content={props.content} 
                    />
                    }
                </div>
            )}
            {props.signedIn && 
            <Favourite
            content={props.content}
            favourites={props.favourites}
            setFavourites={props.setFavourites}
            />
            }  
            <h3 className="cursor-pointer mb-4 text-lg font-semibold" onClick={showAuthors}>Authors:</h3>
            {visibleAut && relevantAuthors.map((author, index) => (
                <div key={index} className="bg-white shadow-lg rounded-lg p-4 mb-4">
                    <p className="text-lg font-semibold">{author.author_name}</p>
                    <p className="text-sm text-gray-600">Country/Countries: {author.countries}</p>
                    <p className="text-sm text-gray-600">City/Cities: {author.cities}</p>
                    <p className="text-sm text-gray-600">Institution/s: {author.institutions}</p>
                </div>
            ))}
        </section>
    )
}

export default ContentList
