import { useState, useEffect } from "react";
import {NavLink} from "react-router-dom";

import useGetComposerList from "../../Hook/useGetComposerList";

const ComposerList = () => {
  const [composerList, setComposerList] = useState([]);
  const getComposerList = useGetComposerList();

  useEffect(() => {
    getComposerList().then(data => {
      setComposerList(data.composers);
    });
  }, [])

  return (
    <>
      <h1 className='text-3xl my-12 font-medium text-center text-primary_first font-black'>Composers</h1>
      <div className="flex flex-col my-6 lg:flex md:flex">
        <div className='lg:grid md:grid lg:grid-cols-3 md:grid-cols-2 flex flex-wrap gap-4'>
          {
            composerList.map((composer, index) => (
              <NavLink key={index} to={`/composer/${composer.id}`}
                          className="rounded-lg p-4 w-full shadow-shadow_2">
                <h3 className="text-xl font-bold">{composer.name}</h3>
                <p>{composer.description.substring(0, 100)}</p>
              </NavLink>
            ))
          }
        </div>     
      </div>
    </>
  );
};

export default ComposerList;
