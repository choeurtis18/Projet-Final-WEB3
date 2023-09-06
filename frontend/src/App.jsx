import React from 'react';
import { useSelector } from 'react-redux';
import { BrowserRouter as Router, Switch, Route } from 'react-router-dom';

import Homepage from './pages/Homepage/HomePage';
import MasterclassList from './pages/Masterclass/MasterclassList';
import Masterclass from './pages/Masterclass/Masterclass';
import MasterclassDetails from './pages/MasterclassDetails/MasterclassDetails';
import MasterclassQuizz from './pages/MasterclassQuizz/MasterclassQuizz';
import Composer from './pages/Composers/Composer';
import ComposerList from './pages/Composers/ComposerList';
import Instrument from './pages/Instruments/Instrument';
import InstrumentList from './pages/Instruments/InstrumentList';
import Footer from './pages/Footer/Footer';
import Register from './pages/Registration/Register';
import Login from './pages/Login/Login';
import { RootReducer } from './Reducer/RootReducer' 
import NoPage from './pages/NoPage';
import Navbar from './pages/Nav/Navbar';
import AddInstrument from './pages/Instruments/AddInstrument';
import AddComposer from './pages/Composers/AddComposer';
import AddMasterclass from './pages/Masterclass/AddMasterclass';
import UpdateInstrument from './components/Instrument/UpdateInstrument';
import UpdateComposer from './components/Composer/UpdateComposer';
import UpdateMasterclass from './components/Masterclass/UpdateMasterclass';
import UpdateUser from './pages/User/UpdateUser';
// ... import other components

function App() {

  const userData = useSelector(state => state.login);
  
  return (
    <Router>
      <div className='main-content' >
      <Route
        render={({ location }) => {
          const { pathname } = location;
          const shouldShowNavbar = !(pathname === '/login' || pathname === '/register');

          return shouldShowNavbar ? <Navbar /> : null;
        }}
      />
        <div style={{ flex: '1' }}>
          <Switch>
            {/* Define your routes */}
            <Route exact path="/" component={Homepage} />
            <Route exact path="/masterclasses" component={MasterclassList} />
            <Route exact path="/masterclass/:id" component={Masterclass} />
            <Route exact path="/masterclasses/:id" component={MasterclassDetails} />
            <Route exact path="/masterclassQuizz/:quizId" component={MasterclassQuizz} />
            <Route exact path='/add_masterclass' component={AddMasterclass}/>
            <Route exact path='/update_masterclass/:id' component={UpdateMasterclass}/>
            <Route exact path='/composers' component={ComposerList} />
            <Route exact path='/composer/:id' component={Composer} />
            <Route exact path='/add_composer' component={AddComposer}/>
            <Route exact path='/update_composer/:id' component={UpdateComposer}/>
            <Route exact path='/instruments' component={InstrumentList} />
            <Route exact path='/instrument/:id' component={Instrument} />
            <Route exact path='/add_instrument' component={AddInstrument}/>
            <Route exact path='/update_instrument/:id' component={UpdateInstrument}/>
            <Route exact path='/register' component={Register}/>
            <Route exact path='/users/update' component={UpdateUser}/>
            {/* <Route path='*' component={NoPage}/> */}
            <Route exact path='/login' component={Login}/>

            {/* Add other routes for other tables */}
          </Switch>
        </div>
        <Route
        render={({ location }) => {
          const { pathname } = location;
          const shouldShowNavbar = !(pathname === '/login' || pathname === '/register');

          return shouldShowNavbar ? <Footer /> : null;
        }}
      />
      </div>
    </Router>
  );
}

export default App;
