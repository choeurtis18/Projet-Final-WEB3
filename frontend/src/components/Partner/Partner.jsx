import React, { Component } from 'react';
import Slider from "react-slick";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
import Google from "../../assets/Google.png";
import Facebook from "../../assets/Facebook.png";
import Youtube from "../../assets/Youtube.png";
import Pinterest from "../../assets/Pinterest.png";
import Webflow from "../../assets/Webflow.png";
import Twitch from "../../assets/Twitch.png";


import "./Partner.css";

class Partner extends Component{

    render(){
        const settings = {
            dots: true,
            infinite:true,
            slidesToShow:4,
            slidesToScroll:1,
            autoplay:true,
            speed: 2000,
            autoPlaySpeed: 2000,
            cssEase: "linear"
        };

        return (
            <Slider {...settings}>
                <div className='container-slider'>
                    <img src={Google} alt="" />
                </div>
                <div className='container-slider'>
                    <img src={Facebook} alt="" />
                </div>
                <div className='container-slider'>
                    <img src={Youtube} alt="" />
                </div>
                <div className='container-slider'>
                    <img src={Pinterest} alt="" />
                </div>
                <div className='container-slider'>
                    <img src={Webflow} alt="" />
                </div>
                <div className='container-slider'>
                    <img src={Twitch} alt="" />
                </div>

            </Slider>    
        )
    }
}

export default Partner;