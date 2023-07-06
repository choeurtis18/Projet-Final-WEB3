import { useState, useEffect } from "react";

import useGetComposer from "../../Hook/useGetComposer";

export default function Composer(props) {
    const [composer, setComposer] = useState([]);
    const getComposer = useGetComposer();

    useEffect(() => {
        getComposer(props.id).then(data => {
            setComposer(data.composer);
        });
    }, []);

    return (
        <div className="w-full">
            <h1 className='text-3xl my-12 text-primary_first font-black'>{composer.name}</h1>
            <div className='w-auto'>
                <h2 className="text-2xl font-bold text-mid_primary_first font-black">Description</h2>
                <p className="text-sm">{composer.description}</p>                
            </div>
        </div>
    );
};