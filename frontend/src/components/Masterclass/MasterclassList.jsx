import { useState, useEffect } from "react";
import { NavLink } from "react-router-dom";

import useGetMasterclassList from "../../Hook/useGetMasterclassList";

const MasterclassList = (props) => {
  const [masterclassList, setMasterclassList] = useState([]);
  const getMasterclassList = useGetMasterclassList();

  useEffect(() => {
    getMasterclassList().then(data => {
      setMasterclassList(data.masterclasses);
    });
  }, [])

  const filteredData = masterclassList.filter((el) => {
    if (props.input === '') { //if no input the return the original
      return el;
    } else { //return the item which contains the user input
      return el.title.toLowerCase().includes(props.input) || el.Instrument.name.toLowerCase().includes(props.input)
    }
  })
  
  return (
    <div className="flex flex-col my-4 lg:flex md:flex">
      <div className='lg:grid md:grid lg:grid-cols-3 md:grid-cols-2 flex flex-wrap gap-4'>
        {
          filteredData.map((masterclass, index) => (
            <div key={index} 
                        className="rounded-lg grid p-4 w-full gap-y-4 shadow-shadow_2 card-page">
              <div className="flex flex-col">
                <h3 className="text-xl font-black card-page-title">{masterclass.title}</h3>
                <span className="text-mid_neutral text-sm">{masterclass.Instrument.name}</span>
              </div>
              <p className="text-sm font-black text-mid_neutral">{masterclass.description.substring(0, 100)}</p>
              <NavLink to={`/masterclass/${masterclass.id}`}>
              <p className="text-sm font-black text-right text-primary_first card-page-link">En Savoir plus</p>
              </NavLink>
            </div>
          ))
        }
      </div>     
    </div>
  );
};

export default MasterclassList;
