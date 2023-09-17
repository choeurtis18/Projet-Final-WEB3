import TextField from "@mui/material/TextField";
import RouteLink from "../../components/Route/RouteLink"
import { useState } from "react";
import SearchIcon from '@mui/icons-material/Search';

import AddMasterclass from "../../components/Masterclass/AddMasterclass";
import Get_MasterclassList from "../../components/Masterclass/MasterclassList";

const MasterclassList = () => {
    const [inputText, setInputText] = useState("");
    let inputHandler = (e) => {
      var lowerCase = e.target.value.toLowerCase();
      setInputText(lowerCase);
    };

    return (
        <div className="w-full px-4 lg:px-40 py-5 md:px-16">
            <div className="flex items-center justify-start pt-10">
                <RouteLink text="Accueil" nav_link="/"></RouteLink>
                <svg className="mr-3 stroke-mid_primary_first" xmlns="http://www.w3.org/2000/svg" height="0.7em" viewBox="0 0 320 512"><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg>
                <RouteLink text="Masterclass" nav_link="#"></RouteLink>
            </div>
            <div className="grid gap-x-16 my-12 lg:flex md:flex my-12 gap-4">
                <h1 className='text-3xl font-medium text-primary_first font-bold font-black lg:w-2/3 md:w-2/3 title-page'>Liste des Masterclass</h1>
                <div className="search lg:w-1/3 md:w-1/3">
                <TextField
                id="outlined-basic"
                onChange={inputHandler}
                className='lg:w-1/3 md:w-1/3 input-search'
                variant="outlined"
                fullWidth
                placeholder="Recherchez une formation"
                InputProps={{
                    startAdornment: (
                    <SearchIcon color="action" fontSize="large" style={{ paddingRight: '10px' }} />
                    ),
                }}
                />
                </div>
            </div>
            <Get_MasterclassList input={inputText}></Get_MasterclassList>
        </div>
    );
};

export default MasterclassList;
