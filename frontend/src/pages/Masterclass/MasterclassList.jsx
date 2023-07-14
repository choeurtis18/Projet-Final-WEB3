import TextField from "@mui/material/TextField";
import { useState } from "react";

import AddMasterclass from "../../components/Masterclass/AddMasterclass";
import Get_MasterclassList from "../../components/Masterclass/MasterclassList";

const MasterclassList = () => {
    const [inputText, setInputText] = useState("");
    let inputHandler = (e) => {
      //convert input text to lower case
      var lowerCase = e.target.value.toLowerCase();
      setInputText(lowerCase);
    };

    return (
        <div className="w-full px-4 lg:px-16 md:px-16">
            <div className="grid gap-x-16 my-12 lg:flex md:flex my-12 gap-4">
                <h1 className='text-3xl font-medium text-primary_first font-black lg:w-2/3 md:w-2/3'>Masterclasses</h1>
                <div className="search lg:w-1/3 md:w-1/3">
                    <TextField id="outlined-basic" onChange={inputHandler} className='lg:w-1/3 md:w-1/3' 
                            variant="outlined" fullWidth label="Search"/>
                </div>
            </div>
            <Get_MasterclassList input={inputText}></Get_MasterclassList>
        </div>
    );
};

export default MasterclassList;
