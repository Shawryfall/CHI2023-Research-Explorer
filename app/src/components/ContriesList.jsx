import { useState, useEffect } from 'react'
/**
 * Countries List
 * 
 * This fetch and returns the countries data, along with a search function
 * 
 * @author Patrick Shaw
 */
function CountriesList() {

    /**
     * State variable for storing the list of countries.
     * @type {[Object[], Function]}
     */
    const [country, setCountry] = useState([])

    /**
     * State variable for storing the current search term.
     * @type {[string, Function]}
     */
    const [search, setSearch] = useState('')

    /**
     * Effect hook for fetching country data from the API.
     * Fetches data on component mount and updates the 'country' state variable.
     */
    useEffect(() => {
        fetch("https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/country")
        .then(response => {
            return response.status === 200 ? response.json() : []
        })
        .then(json => setCountry(json)) 
        .catch(err => {
            console.log(err.message) 
        })
    }, []) 

    /**
     * Event handler for search input changes.
     * Updates the 'search' state variable based on input value.
     *
     * @param {Object} event - The event object from the input field.
     */
    const handleSearch = (event) => setSearch(event.target.value)

    /**
     * Filters the countries based on the search term.
     *
     * @param {Object} affiliation - The country object.
     * @returns {boolean} - True if the country's name includes the search term, false otherwise.
     */
    const searchCountry = (affiliation) => {
        return affiliation.country.toLowerCase().includes(search.toLowerCase())
    }

    /**
     * JSX for rendering the list of countries. Filters the 'country' state based on the
     * search term and maps it to JSX elements.
     * @type {JSX.Element[]}
     */
    const countryJSX = country.filter(searchCountry).map((affiliation, i) => (
        <p key={i}>{affiliation.country}</p> 
    ))

    return (
        <div className="p-4 max-w-md mx-auto bg-white rounded shadow">
            <input 
                value={search} 
                onChange={handleSearch}
                className="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                placeholder="Search..." 
            />
            <div className="mt-4">
                {countryJSX.length > 0 ? countryJSX : <p className="text-gray-600">No results found.</p>}
            </div>
        </div>

    )
}


export default CountriesList
