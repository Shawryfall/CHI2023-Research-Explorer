import { useState, useEffect } from 'react'
/**
 * Preview
 * 
 * Displays a preview of a random content title along with its associated preview video link.
 * The component fetches a single content item from an external API and updates the displayed
 * content every 10 seconds.
 * 
 * @author Patrick Shaw
 */
function Preview() {
    /**
     * State variable for storing the preview content.
     * @type {[Object[], Function]}
     */
    const [preview, setPreview] = useState([])

    /**
     * Effect hook for fetching random content at an interval of 10 seconds.
     * Fetches data on component mount and sets an interval for continuous fetching.
     */
    useEffect(() => {
        const fetchData = () => {
            fetch("https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/preview?limit=1")
                .then(response => {
                    return response.status === 200 ? response.json() : []
                })
                .then(json => {
                    setPreview(json)
                })
                .catch(err => {
                    console.log(err.message)
                })
        }

        const interval = setInterval(fetchData, 10000)

        fetchData()

        return () => clearInterval(interval)
    }, [])

    /**
     * JSX for rendering the preview content.
     * Maps the 'preview' state to JSX elements.
     * @type {JSX.Element[]}
     */
    const previewJSX = preview.map(
        (content, i) => (
            <section key={i} className="bg-white shadow-md rounded-lg p-4 mb-4">
                <p className="text-lg font-semibold mb-2">{content.title}</p>
                <p className="text-blue-600 hover:text-blue-800">
                    <a href={content.preview_video} target="_blank" rel="noopener noreferrer" className="hover:underline">
                        {content.preview_video}
                    </a>
                </p>
            </section>

        )
    )
        return (
            <div className="bg-gray-100 p-4 rounded shadow-md max-w-xl mx-auto my-4">
                {previewJSX}
            </div>
        )
}
 
export default Preview