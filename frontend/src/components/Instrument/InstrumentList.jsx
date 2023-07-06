import { useState, useEffect } from "react";
import {NavLink} from "react-router-dom";

import useGetInstrumentList from "../../Hook/useGetInstrumentList";

const InstrumentList = () => {
  const [instrumentList, setInstrumentList] = useState([]);
  const getInstrumentList = useGetInstrumentList();

  useEffect(() => {
    getInstrumentList().then(data => {
      setInstrumentList(data.instruments);
    });
  }, [])

  return (
    <>
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
    </>
  );
};

export default InstrumentList;
