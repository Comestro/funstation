<form action="function/add_session.php" method="POST" class="space-y-6 p-6 bg-white shadow rounded-lg mx-auto">
    <div class="form-group">
        <label for="name" class="block text-sm font-medium text-gray-700">Kid's Name <span class="text-red-500">*</span>:</label>
        <input type="text" id="name" name="name" placeholder="Enter kid's name"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            required>
    </div>

    <div class="form-group">
        <label for="age" class="block text-sm font-medium text-gray-700">Kid's Age <span class="text-red-500">*</span>:</label>
        <input type="number" id="age" name="age" min="1" placeholder="Enter kid's age"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            required>
    </div>

    <div class="form-group">
        <label for="contact" class="block text-sm font-medium text-gray-700">Contact <span class="text-red-500">*</span>:</label>
        <input type="tel" id="contact" min="10" max="10" name="contact" placeholder="Enter contact number"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            required>
    </div>

    <div class="form-group">
        <label for="check_in_time" class="block text-sm font-medium text-gray-700">Check-in Time <span class="text-red-500">*</span>:</label>
        <input type="datetime-local" id="check_in_time" name="check_in_time"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            required>
    </div>

    <div class="form-group">
    <label for="assigned_hours" class="block text-sm font-medium text-gray-700">Assigned Hours:</label>
    <select id="assigned_hours" name="assigned_hours"
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        <option value="0.5">Half hour</option>
        <option value="1" selected>1 hour</option>
        <option value="2">2 hours</option>
        <option value="3">3 hours</option>
        <option value="4">4 hours</option>
        <option value="5">5 hours</option>
    </select>
    <p class="text-xs text-slate-300">By default 1 hour is assigned automatically</p>
</div>


    <button type="submit"
        class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        Add Session
    </button>
</form>