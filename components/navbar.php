<style>
  .navbar-brand {
    font-size: 1.5rem;
  }

  .navbar-nav .nav-link {
    font-size: 1.1rem;
    margin-left: 1rem;
    margin-right: 1rem;
  }
  .nav-item a{
    color:rgb(0 0 0 / 73%) !important;
  }
.nav-item a:hover {

  color:red !important;
}
  .navbar-toggler {
    border: none;
  }

  @media (max-width: 768px) {
    .navbar-nav {
      flex-direction: column;
      text-align: center;
    }

    .navbar-nav .nav-link {
      margin-top: 1rem;
      margin-bottom: 1rem;
    }
  }

</style>
<nav id="navigation" class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"> <img src="components/logo.jpg" alt="" width="80px" > </a>
  <button class="navbar-toggler" type="button" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="#"><i class="fas fa-home"></i> Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-search"></i> Search</a>
        <div class="dropdown-menu">
          <a class="dropdown-item search-option" href="#" data-type="location">Location</a>
          <a class="dropdown-item search-option" href="#" data-type="blood-group">Blood Group</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"><i class="fas fa-envelope"></i> Messages</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"><i class="fas fa-bell"></i> Notifications</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </li>
      <li class="nav-item">
        <!-- <a class="nav-link" href="#"><i class="fas fa-user-plus"></i> Sign up</a> -->
      </li>
    </ul>

    <form class="form-inline my-2 my-lg-0">
      <div class="search-bar">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <ul class="list-group search-suggestions"></ul>
      </div>
    </form>
  </div>
</nav>

<script>
  const navbarToggler = document.querySelector('.navbar-toggler');
  const navbarCollapse = document.querySelector('.navbar-collapse');

  navbarToggler.addEventListener('click', () => {
    navbarCollapse.classList.toggle('show');
  });


  const searchInput = document.querySelector('input[type="search"]');
  const searchSuggestions = document.querySelector('.search-suggestions');

  const searchOptionLinks = document.querySelectorAll('.search-option');

  // Show search options dropdown when search button is clicked
  document.querySelector('.nav-link.dropdown-toggle').addEventListener('click', function() {
    document.querySelector('.dropdown-menu').classList.toggle('show');
  });

  // Add click event listeners to search option links
  searchOptionLinks.forEach(function(link) {
    link.addEventListener('click', function(event) {
      event.preventDefault();

      // Update search input placeholder text based on selected option
      searchInput.setAttribute('placeholder', 'Search by ' + this.dataset.type);

      // Add selected option class to search bar
      document.querySelector('.search-bar').classList.add(this.dataset.type);

      // Show search suggestions
      searchSuggestions.classList.add('show');

      // Focus on search input
      searchInput.focus();
    });
  });

  // Hide search options dropdown when clicked outside of it
  document.addEventListener('click', function(event) {
    const dropdown = document.querySelector('.dropdown-menu');
    if (dropdown.classList.contains('show') && !dropdown.contains(event.target)) {
      dropdown.classList.remove('show');
    }
  });

  // Clear search input and suggestions
  searchInput.value = '';
  searchSuggestions.innerHTML = '';

  // Hide search suggestions
  searchSuggestions.classList.remove('show');

  // Remove selected option class from search bar
  document.querySelector('.search-bar').classList.remove(link.dataset.type);


  // Fetch data from the server and display search suggestions
  searchInput.addEventListener('input', function() {
    const query = this.value;
    if (query.trim().length > 0) {
      fetch('/search?q=' + query)
        .then(response => response.json())
        .then(data => {
          if (data.length > 0) {
            searchSuggestions.innerHTML = '';
            data.forEach(item => {
              const li = document.createElement('li');
              li.classList.add('list-group-item');
              li.textContent = item.name;
              searchSuggestions.appendChild(li);
            });
            searchSuggestions.classList.add('show');
          } else {
            searchSuggestions.innerHTML = '<li class="list-group-item">No results found</li>';
            searchSuggestions.classList.add('show');
          }
        })
        .catch(error => console.error(error));
    } else {
      searchSuggestions.innerHTML = '';
      searchSuggestions.classList.remove('show');
    }
  });

  // Add submit event listener to search form
  document.querySelector('.search-bar form').addEventListener('submit', function(event) {
    event.preventDefault();

    // Get selected option class from search bar
    const searchType = document.querySelector('.search-bar').classList[1];

    // Get search query
    const searchQuery = searchInput.value.trim();

    // Redirect to search results page with selected option and query parameters
    window.location.href = '/search?type=' + searchType + '&q=' + searchQuery;
  });
</script>