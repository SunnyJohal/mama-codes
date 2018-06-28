// Vendor libs
import 'bootstrap/js/carousel';
import 'bootstrap/js/transition';
import 'flexslider';
import 'jquery';
import './js/libs/hero-slider';
// Theme files
import common from './routes/common';
import home from './routes/home';
import './style.scss';
import Router from './util/Router';

/**
 * Populate Router instance with DOM routes
 * @type {Router} routes - An instance of our router
 */
const routes = new Router({
  /** All pages */
  common,
  /** Home page */
  home
  /** About Us page, note the change from about-us to aboutUs. */
});

/** Load Events */
jQuery(document).ready($ => {
  routes.loadEvents();
});
