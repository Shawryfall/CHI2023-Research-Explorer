import CountriesList from "../components/ContriesList"

/**
 * Countries page
 * 
 * This is the Countries page for the application
 * 
 * @author Patrick Shaw
 */
function Countries() {
    return (
        <>
            <div className="text-center my-4">
                <h2 className="text-2xl font-bold my-2">Countries</h2>
                <h3 className="text-xl font-medium">Welcome to the Countries page!</h3>
            </div>
            <CountriesList/>
        </>
    )
}
 
export default Countries