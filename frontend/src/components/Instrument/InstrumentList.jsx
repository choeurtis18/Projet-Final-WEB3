import { useState, useEffect } from "react";
import {NavLink} from "react-router-dom";

import useGetInstrumentList from "../../Hook/useGetInstrumentList";
import useAddInstrument from "../../Hook/useAddInstrument";

const InstrumentList = () => {
  const [instrumentList, setInstrumentList] = useState([]);
  const getInstrumentList = useGetInstrumentList();

  useEffect(() => {
    getInstrumentList().then(data => {
      setInstrumentList(data.instruments);
    });
  }, [])


  const [returnMessage, setReturnMessage] = useState('');
  const [instrumentName, setInstrumentName] = useState('');
  const addInstrument = useAddInstrument();
  
  const handleChangeName = (e) => {
      setInstrumentName(e.target.value);
  }

  const handleSubmit = (e) => {
      addInstrument(instrumentName).then(data => {
          setReturnMessage(data.messages);
      });
  }

  return (
    <div className="w-full">
        <h1 className='text-3xl my-12 font-medium text-center text-primary_first font-black'>Instruments</h1>
        <div className="flex flex-col my-4 lg:flex md:flex">
          <div className='lg:grid md:grid lg:grid-cols-3 md:grid-cols-2 flex flex-wrap gap-4'>
            {
              instrumentList.map((instrument, index) => (
                <NavLink key={index} to={`/instrument/${instrument.id}`}
                            className="rounded-lg p-4 w-full shadow-shadow_2">
                  <h3 className="text-xl font-black">{instrument.name}</h3>
                </NavLink>
              ))
            }
          </div>     
        </div>

        <div className="my-6 lg:flex md:flex">
          <span className=''>{returnMessage}</span>
          <form className='bg-white w-full shadow-shadow_3 rounded px-6 py-2' onSubmit={handleSubmit}>
            <h2 htmlFor='message' className='my-2 form-label text-xl font-black'>Ajoutez un instrument</h2>
            <div className="mb-4">
              <h3 className="block text-sm font-medium mb-2">Nom de l'instrument</h3>
              <input className="shadow border rounded w-full p-3 focus:outline-none"
                    type="text" id='instrumentName' onChange={handleChangeName} value={instrumentName}/>
            </div>
          </form>
        </div>
    </div>
  );
};

export default InstrumentList;
