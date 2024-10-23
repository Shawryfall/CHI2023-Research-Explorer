import toast, { Toaster } from 'react-hot-toast'

/**
 * favourite
 * 
 * 
 * Provides functionality to mark a content item as a favourite or remove it from favourites.
 * It interacts with an external API to update the user's favourite content and uses toast notifications
 * to provide feedback on the action's success or failure. The component displays a heart icon
 * to indicate the current favourite status of the content.
 * 
 * @author Patrick Shaw
 */
function Favourite(props) {
    /**
    * Removes the current content from the user's favourites.
    * Sends a DELETE request to the API and updates the favourites state on success.
    */
    const unFavourite = () => {
        fetch('https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/favourites?content_id='+props.content.id,
            {
            method: 'DELETE',
            headers: new Headers({"Authorization": "Bearer "+localStorage.getItem('token')}),
            }
        )
        .then(res => {
            if ((res.status === 200) || (res.status === 204)) {
                toast.success("Successfully unfavourited!")
                props.setFavourites(props.favourites.filter(
                    fav => fav !== props.content.id
                )) 
            } else {
                throw new Error(`HTTP error! status: ${response.status}`)
            }
        })
        .catch(error => {
            console.error("Error:", error)
            toast.error("Failed to unfavourite!")
        })
    }

    /**
     * Adds the current content to the user's favourites.
     * Sends a POST request to the API and updates the favourites state on success.
     */
    const setFavourite = () => {
        let formData = new FormData()
        formData.append('content_id', props.content.id)
            
        fetch('https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/favourites',
            {
            method: 'POST',
            headers: new Headers({"Authorization":"Bearer "+localStorage.getItem('token')}),
            body: formData,
            }
        )
        .then(res => {
            if ((res.status === 200) || (res.status === 204)) {
                props.setFavourites([...props.favourites, props.content.id])
                toast.success("Successfully favourited!")
            } else {
                throw new Error(`HTTP error! status: ${response.status}`)
            }
        })
        .catch(error => {
            console.error("Error:", error)
            toast.error("Failed to favourite!")
        })
    }

    /**
     * Determines the favourite status of the content and returns the appropriate icon.
     * A filled heart icon (💘) indicates the content is a favourite, and an unfilled icon (🔲) otherwise.
     * @type {JSX.Element}
     */
    const isFavourite = (props.favourites.includes(props.content.id)) 
    ? <span onClick={unFavourite}>💘</span>
    : <span onClick={setFavourite}>🔲</span>

    return (
        <>
            {isFavourite}
            <Toaster
            position="top-center"
            reverseOrder={false}
            />
        </>    
    )
}

export default Favourite