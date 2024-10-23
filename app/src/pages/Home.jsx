import Preview from '/src/components/Preview'
/**
 * Home page
 * 
 * This is the main landing page for the application
 * 
 * @author Patrick Shaw
 */
function Home() {
    return (
        <>
            <div className="text-center my-4">
                <h2 className="text-2xl font-bold my-2">Home</h2>
                <h3 className="text-xl font-medium">Welcome to the Home page!</h3>
            </div>
            <Preview/>
        </>
    )
}
 
export default Home