import './App.css';
import Composer from './components/Composer/Composer';
import ComposerList from './components/Composer/ComposerList';
import HomePage from './pages/Homepage/HomePage';
import {BrowserRouter, Routes, Route} from "react-router-dom";

function App() {

  return (
    <BrowserRouter>
      <Routes>
        <Route path='/' element={<HomePage/>}/>
        <Route path='/composers' element={<ComposerList/>}/>
        <Route path='/composer/:id' element={<Composer/>}/>
      </Routes>
    </BrowserRouter>
  )
}

export default App
