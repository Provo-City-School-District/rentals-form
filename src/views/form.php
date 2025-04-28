<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provo City School District Facility Rentals Application</title>
    <link rel="stylesheet" href="assets/reset.css">
    <link rel="stylesheet" href="assets/main.css?v=1.0.0">
</head>

<body>
    <h1>Provo City School District Facility Rental Application</h1>
    <form action="../forms/form-handler.php" method="POST">
        <h2>Organizer Information</h2>

        <label for="event_name">Event Name:</label>
        <input type="text" id="event_name" name="event_name" required>

        <label for="rate_group">Rate Group:</label>
        <p><a href="https://provo.edu/policies-procedures-forms/6000-finance-and-operations/policy-6810-provo-city-school-district-facility-rental-policy/" target="_blank">Rate group information can be found in policy procedure 6810</a></p>
        <select id="rate_group" name="rate_group" required>
            <option value="1">Category 1</option>
            <option value="2">Category 2</option>
            <option value="3">Category 3</option>
            <option value="4">Category 4</option>
            <option value="5">Category 5</option>
        </select>

        <label for="nonprofit-yes">Is the Responsible Party a registered 501(c)(3) non-profit?</label>
        <div class="radio-group">
            <input type="radio" id="nonprofit-yes" name="nonprofit" value="yes" onclick="toggleNonprofitAttachment(true)" required> Yes
            <input type="radio" id="nonprofit-no" name="nonprofit" value="no" onclick="toggleNonprofitAttachment(false)" required> No
        </div>

        <div id="nonprofit-attachment-container" style="display: none;">
            <label for="nonprofit-document">Attach 501(c)(3) IRS Letter of Determination (PDF only):</label>
            <input type="file" id="nonprofit-document" name="nonprofit_document" accept="application/pdf">
        </div>

        <label for="commercial-yes">Is the Responsible Party a Commercial business?</label>
        <div class="radio-group">
            <input type="radio" id="commercial-yes" name="commercial" value="yes" required> Yes
            <input type="radio" id="commercial-no" name="commercial" value="no" required> No
        </div>

        <label for="responsible_party">Responsible Party:</label>
        <input type="text" id="responsible_party" name="responsible_party" required>

        <label for="organization">Organization:</label>
        <input type="text" id="organization" name="organization" required>

        <label for="primary_contact">Primary Contact:</label>
        <input type="text" id="primary_contact" name="primary_contact" required>

        <label for="phone">Contact Phone:</label>
        <input type="text" id="phone" name="phone" required>

        <label for="email">Contact Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="description">Description of Event:</label>
        <p><em>To facilitate a seamless rental process, please provide comprehensive details about your event, including required equipment, any special accommodations, or other relevant information not captured in the application.</em></p>
        <p><em>This will help ensure all logistical and technical requirements are properly addressed.</em></p>
        <textarea id="description" name="description" required></textarea>

        <h2>School Requested</h2>
        <label for="location_request">Location Request:</label>
        <select id="location_request" name="location_request" onchange="updateSpaces()" required>
            <option value="">Select a location</option>
            <option value="38">District Office</option>
            <option value="100">Amelia Earhart</option>
            <option value="101">Canyon Crest</option>
            <option value="102">Edgemont</option>
            <option value="103">Provo Peaks</option>
            <option value="104">Franklin</option>
            <option value="108">Grandview</option>
            <option value="118">Lakeview</option>
            <option value="120">Provost</option>
            <option value="122">Rock Canyon</option>
            <option value="123">Spring Creek</option>
            <option value="124">Sunset View</option>
            <option value="128">Timpanogos</option>
            <option value="132">Wasatch</option>
            <option value="134">Westridge</option>
            <option value="404">Centennial Middle</option>
            <option value="035">Dixon</option>
            <option value="555">Slate Canyon</option>
            <option value="408">Shoreline Middle</option>
            <option value="560">Oak Springs</option>
            <option value="590">Vantage Point</option>
            <option value="610">Central Utah Enterprises</option>
            <option value="610">East Bay Post High</option>
            <option value="641">Preschool</option>
            <option value="704">Provo High</option>
            <option value="712">Timpview High</option>
            <option value="730">Independence High</option>
            <option value="740">Provo Adult Education</option>
            <option value="818">CLC</option>
            <option value="1200">Hillside</option>
            <option value="1600">Transportation</option>
            <option value="1700">Maintenance</option>
            <option value="1896">Aux Services</option>
            <option value="1510">Public Relations/Communications</option>
            <option value="1897">Technology</option>
            <option value="510">eSchool</option>
        </select>

        <div id="space_request_container" style="display: none;">
            <label for="space_request">Space Request:</label>
            <select id="space_request" name="space_request">
                <option value="">Select a space</option>
                <!-- Options will be dynamically populated -->
            </select>
        </div>
        <div class="inline-group">
            <label for="date">Date of Event:</label>
            <input type="date" id="date" name="date" required>
        </div>

        <div class="inline-group">
            <label for="setup_start_time">Setup Start Time:</label>
            <input type="time" id="setup_start_time" name="setup_start_time" required>
        </div>

        <div class="inline-group">
            <label for="event_start_time">Event Start Time:</label>
            <input type="time" id="event_start_time" name="event_start_time" required>
        </div>

        <div class="inline-group">
            <label for="event_end_time">Event End Time:</label>
            <input type="time" id="event_end_time" name="event_end_time" required>
        </div>

        <div class="inline-group">
            <label for="cleanup_end_time">Cleanup End Time:</label>
            <input type="time" id="cleanup_end_time" name="cleanup_end_time" required>
        </div>
        <label for="number_of_people">Number of People Expected:</label>
        <input type="number" id="number_of_people" name="number_of_people" required>

        <label for="tickets-yes">Will concessions be sold at the event?</label>
        <div class="radio-group">
            <input type="radio" id="tickets-yes" name="tickets" value="yes" required> Yes
            <input type="radio" id="tickets-no" name="tickets" value="no" required> No
        </div>
        <p><em>If concessions are sold during your event, you assume full responsibility for any damage to the premises or property resulting from spills or stains.</em></p>
        <p><em>You will also be responsible for any associated cleaning costs.</em></p>

        <h2>Event Setup Needs (if applicable)</h2>
        <div class="checkbox-group">
            <input type="checkbox" id="microphone" name="audio_visual_needs[]" value="microphone">
            <label for="microphone">Microphone (approximate additional cost: $100)</label>
        </div>
        <div class="checkbox-group">
            <input type="checkbox" id="projector" name="audio_visual_needs[]" value="projector">
            <label for="projector">Projector (approximate additional cost: $100)</label>
        </div>
        <div class="checkbox-group">
            <input type="checkbox" id="speakers" name="audio_visual_needs[]" value="speakers">
            <label for="speakers">Speakers (approximate additional cost: $100)</label>
        </div>
        <div class="checkbox-group">
            <input type="checkbox" id="lighting" name="audio_visual_needs[]" value="lighting">
            <label for="lighting">Lighting (approximate additional cost: $100)</label>
        </div>
        <div class="checkbox-group">
            <input type="checkbox" id="tables" name="audio_visual_needs[]" value="tables">
            <label for="tables">Tables (approximate additional cost: $100)</label>
        </div>
        <div class="checkbox-group">
            <input type="checkbox" id="chairs" name="audio_visual_needs[]" value="chairs">
            <label for="chairs">Chairs (approximate additional cost: $100)</label>
        </div>
        <button type="submit">Submit</button>
    </form>
</body>
<script src="assets/main.js?v=1.0.0"></script>

</html>