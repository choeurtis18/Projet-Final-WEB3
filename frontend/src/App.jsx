import React from 'react';
import { BrowserRouter as Router, Switch, Route } from 'react-router-dom';

import Nav from './pages/Nav/Nav';
import Homepage from './pages/Homepage/HomePage';
import MasterclassQuizz from './pages/MasterclassQuizz/MasterclassQuizz';
import MasterclassDetails from './pages/MasterclassDetails/MasterclassDetails';
import Footer from './pages/Footer/Footer';
// ... import other components

function App() {
  return (
    <Router>
      <Nav/>
      <Switch>
        {/* Define your routes */}
        <Route exact path="/" component={Homepage} />
        <Route exact path="/masterclass/:id" component={MasterclassDetails} />
        <Route exact path="/masterclassQuizz/:quizId" component={MasterclassQuizz} />

        {/* Add other routes for other tables */}
      </Switch>
      <Footer/>
    </Router>
  );
}

export default App;
