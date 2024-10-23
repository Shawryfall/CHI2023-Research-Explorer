<h1>CHI2023-Research-Explorer</h1>

<p>Developed a web application to display research presented at the ACM CHI 2023 conference. Built a web API using object-oriented PHP to retrieve research data from a database in JSON format and implemented user authentication and note-taking functionality. The front end was developed using React and Tailwind CSS to provide a user-friendly interface for viewing research content and managing notes.</p>

<a href="https://w20012045.nuwebspace.co.uk/kf6012/coursework/app/">Live Demo</a>

<h2>👨‍💻 Part 1: Backend</h2>

<ul>
  <li><b>Endpoint 1: Developer</b> <br/>
    <a href="https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/developer">https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/developer</a> <br/>
    Parameters: None
  </li>
  
  <li><b>Endpoint 2: Country</b> <br/>
    <a href="https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/country">https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/country</a> <br/>
    Parameters: None
  </li>

  <li><b>Endpoint 3: Preview</b> <br/>
    <a href="https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/preview">https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/preview</a> <br/>
    Parameters: <code>limit</code> (e.g., <code>preview?limit=1</code>) – Only accepts number values.
  </li>

  <li><b>Endpoint 4: Author and Affiliation</b> <br/>
    <a href="https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/author-and-affiliation">https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/author-and-affiliation</a> <br/>
    Parameters:
    <ul>
      <li><code>content</code> (e.g., <code>author-and-affiliation?content=99140</code>)</li>
      <li><code>country</code> (e.g., <code>author-and-affiliation?country=japan</code>)</li>
    </ul>
  </li>

  <li><b>Endpoint 5: Content</b> <br/>
    <a href="https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/content">https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/content</a> <br/>
    Parameters:
    <ul>
      <li><code>page</code> (e.g., <code>content?page=2</code>)</li>
      <li><code>type</code> (e.g., <code>content?type=paper</code>)</li>
    </ul>
  </li>

  <li><b>Endpoint 6: Token</b> <br/>
    <a href="https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/token">https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/token</a> <br/>
    Parameters: Authorization headers for username and password.
  </li>

  <li><b>Endpoint 7: Note</b> <br/>
    <a href="https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/note">https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/note</a> <br/>
    Parameters: <code>content_id</code> (e.g., <code>note?content_id=95692</code>).
  </li>

  <li><b>Endpoint 8: Favourites</b> <br/>
    <a href="https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/favourites">https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/favourites</a> <br/>
    Parameters: None.
  </li>
</ul>

<h2>👨‍💻 Part 2: Frontend</h2>

<ul>
  <li><b>Landing page (home page):</b> <br/>
    <a href="https://w20012045.nuwebspace.co.uk/kf6012/coursework/app/">https://w20012045.nuwebspace.co.uk/kf6012/coursework/app/</a> <br/>
    Notable considerations: This page shows a random preview of one piece of content (with title and preview_video link) every time the data is fetched. I've added an interval so that a new random piece of content is displayed every 10 seconds.
  </li>

  <li><b>Countries page:</b> <br/>
    <a href="https://w20012045.nuwebspace.co.uk/kf6012/coursework/app/countries">https://w20012045.nuwebspace.co.uk/kf6012/coursework/app/countries</a> <br/>
    Notable considerations: This page shows a list of all the relevant countries, there is a search feature letting you search for a specific country. If no country is found, "no results found" will be shown.
  </li>

  <li><b>Content page:</b> <br/>
    <a href="https://w20012045.nuwebspace.co.uk/kf6012/coursework/app/content">https://w20012045.nuwebspace.co.uk/kf6012/coursework/app/content</a> <br/>
    Notable considerations: This page displays a list of content with title, abstract, type, award (if available), link, and preview_video link (if available), along with relevant authors and their specific affiliations for each paper. Content details can be expanded by clicking the title, and authors' details can be expanded by clicking Authors. Pagination has been implemented to navigate between pages of 20 pieces of content at most. Type selection allows you to select a specific type of content to be displayed from a dropdown box. If there is no content for a specific type or page, "no relevant content for type or page." will be shown, and you will be unable to go to the next page.
  </li>

  <li><b>Menu and routes:</b> <br/>
    You can navigate through these pages using the route handler in the menu component and app.jsx.
  </li>

  <li><b>Not found page:</b> <br/>
    <a href="https://w20012045.nuwebspace.co.uk/kf6012/coursework/app/sashjhswhsjw">https://w20012045.nuwebspace.co.uk/kf6012/coursework/app/sashjhswhsjw</a> <br/>
    You can access the Not Found page by putting in a link like this or any other gibberish following app/ in the URL. This page also contains an image.
  </li>

  <li><b>Sign-in functionality (feature 1):</b> <br/>
    You can sign in on any page, and if you enter the correct details, you will be signed in successfully and able to access features only available to those signed in. If you enter the wrong password and/or username, the respective fields will turn red. You are logged out after 30 mins as the token expires.
  </li>

  <li><b>Notes (feature 2):</b> <br/>
    If you are signed in, you can view the specific user's relevant notes for each piece of content if they have one. You can save a new note, that is not empty or over 255 characters, using the "Save note" button (uses POST). You can delete any note by pressing the delete button, and it will be removed (uses DELETE).
  </li>

  <li><b>Favourites (feature 3):</b> <br/>
    Similarly, if you are signed in, you can view the specific user's favourites if they have any. You can favourite individual pieces of content one at a time (uses POST). You can unfavourite individual pieces of content one at a time (uses DELETE).
  </li>

  <li><b>Toast:</b> <br/>
    Toast has been used to display pop-ups on the page for things like successfully signed in, incorrect username and/or password, session expired, successfully or failed to post/delete notes or favourites, "note cannot be empty," and "note cannot exceed 255 characters."
  </li>
</ul>
