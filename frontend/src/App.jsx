import React from 'react';
import { BrowserRouter as Router, Switch, Route } from 'react-router-dom';

import Homepage from './pages/Homepage/HomePage';
import MasterclassList from './pages/Masterclass/MasterclassList';
import Masterclass from './pages/Masterclass/Masterclass';
import MasterclassQuizz from './pages/MasterclassQuizz/MasterclassQuizz';
import Composer from './pages/Composers/Composer';
import ComposerList from './pages/Composers/ComposerList';
import Instrument from './pages/Instruments/Instrument';
import InstrumentList from './pages/Instruments/InstrumentList';
import Footer from './pages/Footer/Footer';
import Register from './pages/Registration/Register';
import NoPage from './pages/NoPage';
import Navbar from './pages/Nav/Navbar';
// ... import other components


function App() {
  return (
    <Router>
      <div className='main-content' >
        <Navbar />
        <div style={{ flex: '1' }}>
          <Switch>
            {/* Define your routes */}
            <Route exact path="/" component={Homepage} />
            <Route exact path="/masterclasses" component={MasterclassList} />
            <Route exact path="/masterclass/:id" component={Masterclass} />
            <Route exact path="/masterclassQuizz/:quizId" component={MasterclassQuizz} />
            <Route exact path='/composers' component={ComposerList} />
            <Route exact path='/composer/:id' component={Composer} />
            <Route exact path='/instruments' component={InstrumentList} />
            <Route exact path='/instrument/:id' component={Instrument} />
            <Route exact path='/register' component={Register}/>
            <Route path='*' component={NoPage}/>

            {/* Add other routes for other tables */}
          </Switch>
        </div>
        <Footer />
      </div>

    </Router>
  );
}

export default App;
