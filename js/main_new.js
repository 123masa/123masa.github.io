// Events data loaded from database
let eventsData = [];

// Function to load events from database
async function loadEventsFromDatabase() {
    try {
        const response = await fetch('get_events.php');
        const data = await response.json();
        eventsData = data;
        return data;
    } catch (error) {
        console.error('Error loading events:', error);
        return [];
    }
}

// Function to display featured events
function displayFeaturedEvents() {
    const featuredEventsContainer = document.getElementById('featuredEvents');
    const featuredEvents = eventsData.filter(event => event.featured);

    featuredEventsContainer.innerHTML = '';

    featuredEvents.forEach(event => {
        const eventCard = `
            <div class="col-md-4 mb-4">
                <div class="card h-100 event-card" data-id="${event.id}">
                    <img src="${event.image}" class="card-img-top" alt="${event.title}">
                    <div class="card-body">
                        <span class="badge bg-primary mb-2">${event.category}</span>
                        <h5 class="card-title">${event.title}</h5>
                        <p class="card-text">${event.description.substring(0, 100)}...</p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> ${event.date}</small>
                        <br>
                        <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i> ${event.location}</small>
                    </div>
                </div>
            </div>
        `;
        featuredEventsContainer.innerHTML += eventCard;
    });

    // Add click event to open details page
    document.querySelectorAll('.event-card').forEach(card => {
        card.addEventListener('click', () => {
            const eventId = card.getAttribute('data-id');
            window.location.href = `event.php?id=${eventId}`;
        });
    });
}

// Function to display latest events
function displayLatestEvents() {
    const latestEventsContainer = document.getElementById('latestEvents');
    // Display only non-featured events
    const latestEvents = eventsData.filter(event => !event.featured);

    latestEventsContainer.innerHTML = '';

    latestEvents.forEach(event => {
        const eventCard = `
            <div class="col-md-4 mb-4">
                <div class="card h-100 event-card" data-id="${event.id}">
                    <img src="${event.image}" class="card-img-top" alt="${event.title}">
                    <div class="card-body">
                        <span class="badge bg-primary mb-2">${event.category}</span>
                        <h5 class="card-title">${event.title}</h5>
                        <p class="card-text">${event.description.substring(0, 100)}...</p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> ${event.date}</small>
                        <br>
                        <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i> ${event.location}</small>
                    </div>
                </div>
            </div>
        `;
        latestEventsContainer.innerHTML += eventCard;
    });

    // Add click event to open details page
    document.querySelectorAll('.event-card').forEach(card => {
        card.addEventListener('click', () => {
            const eventId = card.getAttribute('data-id');
            window.location.href = `event.php?id=${eventId}`;
        });
    });
}

// Function to filter events by category
function setupCategoryFilters() {
    document.querySelectorAll('.category-filter').forEach(button => {
        button.addEventListener('click', () => {
            const category = button.getAttribute('data-category');
            filterEvents(category);
        });
    });
}

function filterEvents(category) {
    const events = document.querySelectorAll('.event-card');

    events.forEach(event => {
        const eventCategory = event.querySelector('.badge').textContent;

        if (category === 'all' || eventCategory === category) {
            event.parentElement.style.display = 'block';
        } else {
            event.parentElement.style.display = 'none';
        }
    });
}

// Function to validate contact form
function validateContactForm() {
    const form = document.getElementById('contactForm');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const message = document.getElementById('message').value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        let isValid = true;
        let errorMessage = '';

        if (name === '') {
            isValid = false;
            errorMessage += 'Name is required.<br>';
        }

        if (email === '' || !emailRegex.test(email)) {
            isValid = false;
            errorMessage += 'Invalid email address.<br>';
        }

        if (message === '') {
            isValid = false;
            errorMessage += 'Message is required.<br>';
        }

        if (isValid) {
            // Show success message using Bootstrap Alert
            const successAlert = `
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Sent successfully!</strong> Thank you for contacting us, we will reply as soon as possible.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            document.getElementById('formMessages').innerHTML = successAlert;
            form.reset();
        } else {
            // Show error message
            const errorAlert = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Sending error:</strong><br> ${errorMessage}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            document.getElementById('formMessages').innerHTML = errorAlert;
        }
    });
}

// Initialize all components when page loads
document.addEventListener('DOMContentLoaded', async function() {
    // Load events from database first
    await loadEventsFromDatabase();
    
    // Initialize home page
    if (document.getElementById('featuredEvents')) {
        displayFeaturedEvents();
        displayLatestEvents();
        setupCategoryFilters();
    }

    // Initialize contact form
    validateContactForm();

    // Initialize event details page
    if (document.getElementById('eventDetails')) {
        displayEventDetails();
    }

    // Initialize all events page
    if (document.getElementById('allEvents')) {
        displayAllEvents();
        setupEventFilters();
    }
});

// Function to display event details (for event.php page)
function displayEventDetails() {
    const urlParams = new URLSearchParams(window.location.search);
    const eventId = urlParams.get('id');

    if (!eventId) {
        document.getElementById('eventDetails').innerHTML = `
            <div class="alert alert-danger" role="alert">
                Event not found.
            </div>
        `;
        return;
    }

    const event = eventsData.find(e => e.id == eventId);

    if (!event) {
        document.getElementById('eventDetails').innerHTML = `
            <div class="alert alert-danger" role="alert">
                Event not found.
            </div>
        `;
        return;
    }

    document.getElementById('eventDetails').innerHTML = `
        <div class="row">
            <div class="col-md-8">
                <img src="${event.image}" class="img-fluid rounded mb-4" alt="${event.title}">
                <h1>${event.title}</h1>
                <div class="d-flex align-items-center mb-3">
                    <span class="badge bg-primary me-2">${event.category}</span>
                    <span class="text-muted"><i class="far fa-calendar-alt me-1"></i> ${event.date}</span>
                    <span class="text-muted ms-3"><i class="fas fa-map-marker-alt me-1"></i> ${event.location}</span>
                </div>
                <p>${event.description}</p>
                
                <div class="d-flex mt-4">
                    <button class="btn btn-primary me-2" id="addToCalendar"><i class="far fa-calendar-plus me-1"></i> Add to Calendar</button>
                    <button class="btn btn-outline-primary" id="shareEvent"><i class="fas fa-share-alt me-1"></i> Share</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Event Information</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Date:</strong> ${event.date}</p>
                        <p><strong>Location:</strong> ${event.location}</p>
                        <p><strong>Category:</strong> ${event.category}</p>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Related Events</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            ${getRelatedEvents(event.id, event.category).map(relatedEvent => `
                                <a href="event.php?id=${relatedEvent.id}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">${relatedEvent.title}</h6>
                                        <small>${relatedEvent.date}</small>
                                    </div>
                                    <small class="text-muted">${relatedEvent.location}</small>
                                </a>
                            `).join('')}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Add event listeners for buttons
    document.getElementById('addToCalendar')?.addEventListener('click', function() {
        alert('Event added to your calendar');
    });
    
    document.getElementById('shareEvent')?.addEventListener('click', function() {
        if (navigator.share) {
            navigator.share({
                title: event.title,
                text: event.description,
                url: window.location.href
            })
            .catch(error => {
                console.log('Error sharing:', error);
            });
        } else {
            alert('Share link: ' + window.location.href);
        }
    });
}

// Function to get related events
function getRelatedEvents(currentEventId, category) {
    return eventsData
        .filter(event => event.id != currentEventId && event.category === category)
        .slice(0, 3);
}

// Function to display all events (for events.php page)
function displayAllEvents() {
    const eventsContainer = document.getElementById('allEvents');
    
    eventsData.forEach(event => {
        const eventCard = `
            <div class="col-md-6 col-lg-4 mb-4" data-category="${event.category}">
                <div class="card h-100 event-card" data-id="${event.id}">
                    <img src="${event.image}" class="card-img-top" alt="${event.title}">
                    <div class="card-body">
                        <span class="badge bg-primary mb-2">${event.category}</span>
                        <h5 class="card-title">${event.title}</h5>
                        <p class="card-text">${event.description.substring(0, 100)}...</p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> ${event.date}</small>
                            <a href="event.php?id=${event.id}" class="btn btn-sm btn-primary">Details</a>
                        </div>
                    </div>
                </div>
            </div>
        `;
        eventsContainer.innerHTML += eventCard;
    });
}

// Function to setup event filters on events.php page
function setupEventFilters() {
    const categoryFilter = document.getElementById('categoryFilter');
    const dateFilter = document.getElementById('dateFilter');
    const searchInput = document.getElementById('searchInput');
    
    if (categoryFilter) {
        categoryFilter.addEventListener('change', filterAllEvents);
    }
    
    if (dateFilter) {
        dateFilter.addEventListener('change', filterAllEvents);
    }
    
    if (searchInput) {
        searchInput.addEventListener('keyup', filterAllEvents);
    }
}

function filterAllEvents() {
    const categoryValue = document.getElementById('categoryFilter')?.value || 'all';
    const dateValue = document.getElementById('dateFilter')?.value || '';
    const searchValue = document.getElementById('searchInput')?.value.toLowerCase() || '';
    
    const eventCards = document.querySelectorAll('#allEvents > div');
    
    eventCards.forEach(card => {
        const eventCategory = card.getAttribute('data-category');
        const eventDate = card.querySelector('.card-footer small')?.textContent.split(' ')[1] || '';
        const eventTitle = card.querySelector('.card-title')?.textContent.toLowerCase() || '';
        const eventDescription = card.querySelector('.card-text')?.textContent.toLowerCase() || '';
        
        const categoryMatch = categoryValue === 'all' || eventCategory === categoryValue;
        const dateMatch = !dateValue || eventDate === dateValue;
        const searchMatch = !searchValue || 
                           eventTitle.includes(searchValue) || 
                           eventDescription.includes(searchValue);
        
        if (categoryMatch && dateMatch && searchMatch) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}