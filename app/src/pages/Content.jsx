import ContentGrab from "/src/components/ContentGrab"
/**
 * Content Page
 * 
 * This is the content page for the application
 * 
 * @author Patrick Shaw
 */
function Content(props) {
    return (
        <>
            <div className="text-center my-4">
                <h2 className="text-2xl font-bold my-2">Content</h2>
                <h3 className="text-xl font-medium">Welcome to the Content page!</h3>
            </div>
            <ContentGrab 
            signedIn={props.signedIn} 
            favourites={props.favourites}
            setFavourites={props.setFavourites}/>
        </>
    )
}
 
export default Content