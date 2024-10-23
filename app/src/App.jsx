import { Routes, Route } from "react-router-dom"
import React from 'react'
import { useState } from 'react'
import Home from './pages/Home'
import Countries from './pages/Countries'
import Content from './pages/Content'
import NotFound from '/src/pages/NotFound'
import SignIn from './components/SignIn'
import Menu from './components/Menu'
import Footer from './components/Footer'
/**
 * App
 * 
 * Main application component which serves as the root of the project. It manages global states like
 * user authentication and favourites. It also sets up the routing for the application, rendering
 * different pages based on the URL path. The App component includes the SignIn component, Menu,
 * routing logic for the pages, and a Footer.
 * 
 * @author Patrick Shaw
 */
function App() {
  /**
   * State variable indicating if the user is signed in.
   * @type {[boolean, Function]}
   */
  const [signedIn, setSignedIn] = useState(false)

  /**
   * State variable storing the user's favourite items.
   * @type {[Array, Function]}
   */
  const [favourites, setFavourites] = useState([])

  return (
    <>
      <h1 className="text-4xl md:text-6xl lg:text-8xl font-extrabold text-white my-4 py-2 shadow-lg tracking-widest bg-blue-800 rounded-lg px-4">
        CHI 2023
      </h1>
      
      <SignIn 
      signedIn={signedIn} 
      setSignedIn={setSignedIn}
      favourites={favourites}
      setFavourites={setFavourites}
      />
      <Menu/>
      <Routes>
        <Route path="/" element={<Home />}/>
        <Route path="/countries" element={<Countries />}/>
        <Route path="/content" element={<Content 
        signedIn={signedIn} 
        favourites={favourites}
        setFavourites={setFavourites}/>
        }
      />
        <Route path="*" element={<NotFound />}/>
      </Routes>
      <Footer/>
    </>
  )
}

export default App
