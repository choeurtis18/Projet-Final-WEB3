import { useState, useEffect } from "react";
import { NavLink } from "react-router-dom";

import useGetFormationsList from "../../Hook/useGetFormationsList";

const FormationsList = (props) => {
  const [formationList, setFormationsList] = useState([]);
  const getFormationsList = useGetFormationsList();

  useEffect(() => {
    getFormationsList().then(data => {
      setFormationsList(data.formations);
    });
  }, [])

  const filteredData = formationList.filter((el) => {
    if (props.input === '') { //if no input the return the original
      return el;
    } else { //return the item which contains the user input
      return el.title.toLowerCase().includes(props.input)
    }
  })
  
  return (
    <div className="flex flex-col my-4 lg:flex md:flex">
      <div className='lg:grid md:grid lg:grid-cols-3 md:grid-cols-2 flex flex-wrap gap-4'>
        {
          filteredData.map((formation, index) => (
            <NavLink key={index} to={`/formation/${formation.id}`}
                        className="rounded-lg grid p-4 w-full gap-y-4 shadow-shadow_2">
              <div className="flex flex-col">
                <h3 className="text-xl font-black">{formation.name}</h3>
              </div>
              <p className="text-sm font-black text-mid_neutral">{formation.description.substring(0, 100)}</p>
              <p className="text-sm font-black text-right text-primary_first">En Savoir plus</p>
            </NavLink>
          ))
        }
      </div>     
    </div>
  );
};

export default FormationsList;
