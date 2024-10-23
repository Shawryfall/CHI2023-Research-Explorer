import { useState, useEffect } from 'react'
import ContentList from './ContentList'

/**
 * Content Grab
 * 
 * * Retrieves and displays content from an external API based on the selected type and page number.
 * It also manages pagination and allows the user to filter content by type. The component fetches
 * authors and affiliations separately and passes them down to the ContentList component.
 * 
 * @author Patrick Shaw
 */
function ContentGrab(props) {
    /**
     * State variable for storing fetched content.
     * @type {[Object[], Function]}
     */
    const [content, setContent] = useState([])

    /**
     * State variable for storing authors data.
     * @type {[Object[], Function]}
     */
    const [authors, setAuthors] = useState([])

    /**
     * State variable for managing current page number.
     * @type {[number, Function]}
     */
    const [currentPage, setCurrentPage] = useState(1)

    /**
     * State variable for managing selected content type.
     * @type {[string, Function]}
     */
    const [selectedType, setSelectedType] = useState('')

    /**
     * State variable indicating if there is content available for display.
     * @type {[boolean, Function]}
     */
    const [hasContent, setHasContent] = useState(true)

    /**
     * Fetches content based on page number and content type.
     * @param {number} page - The current page number.
     */
    const fetchContent = (page) => {
        let url = `https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/content?page=${page}`
        if (selectedType) {
            url += `&type=${selectedType}`
        }

        fetch(url)
            .then(response => {
                if (response.status === 204) { 
                    setHasContent(false)
                    return []
                } else {
                    setHasContent(true)
                    return response.status === 200 ? response.json() : []
                }
            })
            .then(data => {
                if (page === currentPage) {
                    setContent(data)
                }
            })
            .catch(err => {
                console.log('Error fetching content:', err.message)
                setHasContent(false)
            })
    }

    /**
     * Fetches content on currentPage or selectedType change.
     */
    useEffect(() => {
        fetchContent(currentPage)
    }, [currentPage, selectedType])

    /**
     * Fetches authors and affiliations on component mount.
     */
    useEffect(() => {
        fetch("https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/author-and-affiliation")
            .then(response => { 
                return response.status === 200 ? response.json() : []
            })
            .then(data => setAuthors(data))
            .catch(err => console.log('Error fetching authors and affiliations:', err.message))
    }, [])

    /**
     * Navigates to the next page if content is available.
     */
    const goToNextPage = () => {
        if (hasContent) {
            setCurrentPage(currentPage + 1)
        }
    }

    /**
     * Navigates to the previous page if not on the first page.
     */
    const goToPreviousPage = () => {
        if (currentPage > 1) {
            setCurrentPage(currentPage - 1)
        }
    }

    /**
     * Updates selected content type and resets page number.
     * @param {string} type - The selected content type.
     */
    const selectType = (type) => {
        setSelectedType(type)
        setCurrentPage(1)
        setHasContent(true)
    }

    /**
     * List of content types available for filtering.
     * @type {string[]}
     */
    const types = [
        "Course", "Demo", "Doctoral Consortium", "Event", "Late-Breaking Work",
        "Paper", "Poster", "Work-in-Progress", "Workshop", "Case Study",
        "Panel", "AltCHI", "SIG", "Keynote", "Interactivity", "Journal",
        "Symposia", "Competitions"
    ]

    /**
     * Handles the change event on the content type select input.
     * @param {Object} e - The event object from the select input.
     */
    const handleTypeChange = (e) => {
        selectType(e.target.value)
    }

    /**
     * JSX for rendering the merged content list.
     * @type {JSX.Element[]}
     */
    let contentMergeJSX = content.map(contentItem => (
        <div key={contentItem.id}>
            <ContentList 
            content={contentItem}
            authors={authors} 
            signedIn={props.signedIn} 
            favourites={props.favourites}
            setFavourites={props.setFavourites}
            />
        </div>
    ))

    return (
        <>
            <div className="p-4">  
                <select 
                value={selectedType} 
                onChange={handleTypeChange}
                className="border border-gray-300 rounded p-2 mb-4"
                >
                <option value="">All Types</option>
                {types.map(type => (
                    <option key={type} value={type}>{type}</option>
                ))}
            </select>
            </div>
            <div className="p-4">
                {currentPage > 1 && (
                    <button className="bg-gray-300 hover:bg-gray-400 text-black py-2 px-4 rounded m-1" 
                    onClick={goToPreviousPage}
                    >
                        Previous
                    </button>
                )}
                <button className="bg-gray-300 hover:bg-gray-400 text-black py-2 px-4 rounded m-1" 
                onClick={goToNextPage}
                >
                    Next
                </button>   
            </div>
            <h2 className="p-4 text-xl font-bold">Page {currentPage}</h2>
            <div className="p-4">
                {contentMergeJSX}
                {!hasContent && <p>No more relevant content for this type or page.</p>}
            </div>
            <div className="p-4">
                {currentPage > 1 && (
                    <button className="bg-gray-300 hover:bg-gray-400 text-black py-2 px-4 rounded m-1" 
                    onClick={goToPreviousPage}
                    >
                        Previous
                    </button>
                )}
                <button className="bg-gray-300 hover:bg-gray-400 text-black py-2 px-4 rounded m-1" 
                onClick={goToNextPage}
                >
                    Next
                </button>
            </div>

        </>
    )
}

export default ContentGrab
