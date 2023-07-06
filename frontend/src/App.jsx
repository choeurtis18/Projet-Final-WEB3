import './App.css';
import Composer from './pages/Composers/Composer';
import ComposerList from './pages/Composers/ComposerList';
import Instrument from './pages/Instruments/Instrument';
import InstrumentList from './pages/Instruments/InstrumentList';
import Masterclass from './pages/Masterclass/Masterclass';
import MasterclassList from './pages/Masterclass/MasterclassList';
import HomePage from './pages/Homepage/HomePage';
import {BrowserRouter, Routes, Route} from "react-router-dom";

function App() {

  return (
    <BrowserRouter>
      <Routes>
        <Route path='/' element={<HomePage/>}/>
        <Route path='/composers' element={<ComposerList/>}/>
        <Route path='/composer/:id' element={<Composer/>}/>
        <Route path='/instruments' element={<InstrumentList/>}/>
        <Route path='/instrument/:id' element={<Instrument/>}/>
        <Route path='/masterclasses' element={<MasterclassList/>}/>
        <Route path='/masterclass/:id' element={<Masterclass/>}/>
      </Routes>
    </BrowserRouter>
  )
}

export default App
