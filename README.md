# Advanced web systems

If you are struggling with the <admin-bookings> component, look in the console (right click - inspect). If it gives an error containing "vue moment" it means that the moment package is not installed
  
https://www.npmjs.com/package/vue-moment
  
In your terminal:

```
npm install --save-dev vue-moment
```

And then paste this in your app.js:

```javascript
Vue.use(require('vue-moment'));
```
