import lost from '/src/assets/lost.jpg'

/**
 * Not found page
 * 
 * This is the 404 not found error page for the application
 * 
 * @author Patrick Shaw
 */
function NotFound() {
    return (
        <div className="flex flex-col items-center justify-center q-screen">
            <h1 className="text-4xl font-bold mb-4">404</h1>
            <p className="text-xl mb-4">Page Not Found</p>
            <img src={lost} alt="Man who is lost" className="w-1/2" />
        </div>
    )
}

export default NotFound
