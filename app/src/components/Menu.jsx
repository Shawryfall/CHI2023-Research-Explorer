import { Link } from "react-router-dom"
/**
 * Menu
 * 
 * Handles menu functionality
 * 
 * @author Patrick Shaw
 */
function Menu() {
  
  
  
    return (
        <>
            <nav className="bg-gray-800 text-white p-4 shadow-md">
                <ul className="flex justify-center space-x-6 md:space-x-10">
                    <li className="hover:bg-gray-700 rounded-md transition-colors duration-200">
                        <Link to='/' className="no-underline px-3 py-2 block">Home</Link>
                    </li>
                    <li className="hover:bg-gray-700 rounded-md transition-colors duration-200">
                        <Link to='/countries' className="no-underline px-3 py-2 block">Countries</Link>
                    </li>
                    <li className="hover:bg-gray-700 rounded-md transition-colors duration-200">
                        <Link to='/content' className="no-underline px-3 py-2 block">Content</Link>
                    </li>
                </ul>
            </nav>


        </>

    )
}

export default Menu