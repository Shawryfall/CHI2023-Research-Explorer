import { useState, useEffect } from 'react'
import toast, { Toaster } from 'react-hot-toast'
/**
 * SignIn functionality
 * 
 * Manages the sign-in functionality for the application. It allows users to sign in using a username and password,
 * handles token storage and validation, and provides sign-out functionality. The component also fetches and updates
 * user favourites upon successful sign-in and periodically checks for token expiration.
 *
 * @author Patrick Shaw
 */
function SignIn(props) {
    /**
     * State variable for storing the username.
     * @type {[string, Function]}
     */
    const [username, setUsername] = useState("")

    /**
     * State variable for storing the password.
     * @type {[string, Function]}
     */
    const [password, setPassword] = useState("")

    /**
     * State variable to indicate sign-in errors.
     * @type {[boolean, Function]}
     */
    const [signInError, setSignInError] = useState(false)

    /**
     * Effect hook to handle token validation and auto sign-out on token expiration.
     */
    useEffect(() => {
        const token = localStorage.getItem('token')
        if (token) {
            if (checkTokenExpiration(token)) {
                signOut()
            } else {
                props.setSignedIn(true)
                getFavourites(token)
            }
        }

        const interval = setInterval(() => {
            const token = localStorage.getItem('token')
            if (token && checkTokenExpiration(token)) {
                signOut()
                toast.error("Session has expired, please sign in again.")
            }
        }, 10000) 

        return () => clearInterval(interval)
    }, [])

    /**
     * Checks if the JWT token is expired.
     * @param {string} token - The JWT token.
     * @return {boolean} - True if the token is expired, false otherwise.
     */
    const checkTokenExpiration = (token) => {
        const payload = JSON.parse(atob(token.split('.')[1]))
        const currentTime = Math.floor(Date.now() / 1000)
        return payload.exp < currentTime
    }

    /**
     * Fetches the user's favourites from the server.
     * @param {string} token - The JWT token.
     */
    const getFavourites = (token) => {
        fetch('https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/favourites',
          {
            method: 'GET',
            headers: new Headers({ "Authorization": "Bearer "+ token })
          })
         .then(response => {
            return response.status === 200 ? response.json() : []
        })
         .then(data => {
            const flattenedData = data.map((content) => content.content_id)
            props.setFavourites(flattenedData) 
            
        })
         .catch(error => console.log(error))
       }

    /**
     * Handles the user sign-in process.
     * Sends a GET request to the server with the encoded username and password.
     */
    const signIn = () => {
        const encodedString = btoa(username + ':' + password)

        fetch('https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/token',
            {
                method: 'GET',
                headers: new Headers({ "Authorization": "Basic " + encodedString })
            }
        )
        .then(response => {
            if(response.status === 200) {
                props.setSignedIn(true)    
                setSignInError(false)
                toast.success("Signed in successfully!")
            } else {
                setSignInError(true)
                toast.error("Incorrect username and/or password.")
            }
            return response.json()
        })
        .then(data => {
            if (data.token) {
                localStorage.setItem('token', data.token)
            }
            getFavourites(data.token)
        })
        .catch(error => console.log(error)) 
    }

    /**
     * Handles the user sign-out process.
     * Removes the JWT token from local storage and updates the signed-in state.
     */
    const signOut = () => {
        props.setSignedIn(false)
        localStorage.removeItem('token') 
    }

    /**
     * Updates the username state based on user input.
     * @param {Object} event - The input event.
     */
    const handleUsername = (event) => {setUsername(event.target.value)}

    /**
     * Updates the password state based on user input.
     * @param {Object} event - The input event.
     */
    const handlePassword = (event) => {setPassword(event.target.value)}

    /**
     * Determines the background color based on sign-in error state.
     * @type {string}
     */
    const bgColour = (signInError) ? " bg-red-200" : "bg-slate-100"

    return (
        <div className="bg-slate-800 p-2 text-md text-right">
            {!props.signedIn && <div className="flex items-center justify-end">
                <input 
                    type="text" 
                    placeholder="username" 
                    className={`p-1 mx-2 rounded-md ${bgColour}`}
                    value={username}
                    onChange={handleUsername}
                />
                <input 
                    type="password" 
                    placeholder="password" 
                    className={`p-1 mx-2 rounded-md ${bgColour}`}
                    value={password}
                    onChange={handlePassword}
                />
                <input 
                    type="submit" 
                    value="Sign In" 
                    className="py-1 px-2 mx-2 bg-green-100 hover:bg-green-500 rounded-md cursor-pointer"
                    onClick={signIn}
                />
            </div>}
            {props.signedIn && <div>
                <input 
                    type="submit" 
                    value="Sign Out" 
                    className="py-1 px-2 mx-2 bg-green-100 hover:bg-green-500 rounded-md cursor-pointer"
                    onClick={signOut}
                />
            </div>}
            <Toaster
            position="top-center"
            reverseOrder={false}
            />
        </div>

  )
}

export default SignIn
