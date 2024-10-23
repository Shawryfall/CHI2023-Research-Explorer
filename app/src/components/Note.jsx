import { useEffect, useState } from 'react'
import toast, { Toaster } from 'react-hot-toast'

/**
 * Note Component
 *
 * Provides a user interface for adding, viewing, and deleting notes associated with a specific content item.
 * It interacts with an external API to fetch, save, and delete notes. The component displays a text area
 * for the note and buttons to save or delete the note. Toast notifications are used to provide feedback
 * on the action's success or failure.
 *
 * @author Patrick Shaw
 */
function Note(props) {
    /**
     * State variable for storing the note associated with the content.
     * @type {[string, Function]}
     */
    const [note, setNote] = useState('')

    /**
     * Fetches the note for the specified content ID on component mount or content ID change.
     */
    useEffect(() => {
        fetch(`https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/note?content_id=` + props.content.id, {
            method: 'GET',
            headers: new Headers({ "Authorization": "Bearer " + localStorage.getItem('token') }),
        })
        .then(response => {
            return response.status === 200 ? response.json() : []
        })
        .then(data => {
            const flattenedData = data.map((content) => content.note)       
            setNote(flattenedData)
        })
        .catch(error => {
            console.log(error)
            setNote('') 
        })
    }, [props.content.id])
     
    /**
     * Saves the current note to the server.
     * Sends a POST request with the note content and updates the state on success.
     */
    const saveNote = () => {
        const noteContent = note.trim()
        if (!noteContent) {
            toast.error("Note cannot be empty.")
            return
        }

        if (noteContent.length > 255) {
            toast.error("Note cannot exceed 255 characters.")
            return
        }
    
        let formData = new FormData()
        formData.append('note', noteContent)
    
        fetch(`https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/note?content_id=` + props.content.id, {
            method: 'POST',
            headers: new Headers({
                "Authorization": `Bearer ${localStorage.getItem('token')}`,
            }),
            body: formData
        })
        .then(response => {
            if (response.status === 200 || response.status === 204) {
                toast.success("Note saved successfully!")
            } else {
                throw new Error(`HTTP error! status: ${response.status}`)
            }
        })
        .catch(error => {
            console.error("Error:", error)
            toast.error("Failed to save the note!")
        })
    }

    /**
     * Deletes the note for the current content.
     * Sends a DELETE request to the server and clears the note state on success.
     */
    const deleteNote = () => {
        fetch(`https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/note?content_id=` + props.content.id, {
            method: 'DELETE',
            headers: new Headers({
                "Authorization": `Bearer ${localStorage.getItem('token')}`,
            }),
        })
        .then(response => {
            if (response.status === 200 || response.status === 204) {
                toast.success("Note deleted successfully!")
                setNote('') // Clear the note from the state
            } else {
                throw new Error(`HTTP error! status: ${response.status}`)
            }
        })
        .catch(error => {
            console.error("Error:", error)
            toast.error("Failed to delete the note!")
        })
    }
    
    
    
    return (
        
        <div className="flex flex-col p-5">
            <h1 class="mb-5 pb-3 border-b border-gray-300">Note:</h1>
            <textarea 
                name="note"
                placeholder="Add or edit your note here" 
                rows="4" 
                cols="50" 
                maxLength="1000" 
                className="p-2"
                value={note}
                onChange={(e) => setNote(e.target.value)}
            />
            <input 
                name="save"
                type="submit" 
                value="save" 
                className="w-full my-2 bg-slate-700 text-white rounded-md"
                onClick={saveNote}
            />
            <input 
                name="delete"
                type="submit" 
                value="delete" 
                className="w-full my-2 bg-red-500 text-white rounded-md"
                onClick={deleteNote}
            />
            <Toaster
            position="top-center"
            reverseOrder={false}
            />
        </div>
    )
}

export default Note

