/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Doctor's pages
require('./components/dashboard/DoctorsPage');
require('./components/dashboard/AddDoctorPage');
require('./components/dashboard/DoctorProfilePage');
require('./components/dashboard/EditDoctorPage');

// Clinic's pages
require('./components/dashboard/AddClinicPage');
require('./components/dashboard/ClinicProfilePage');

// Patient's pages
require('./components/dashboard/AddPatientPage');
require('./components/dashboard/PatientProfilePage');

// Modals
require('./components/dashboard/DoctorListModal');

/**
 * UI scripts
 */
require('./shared/common');