<style>
	.header{
	   position: sticky;
	   top:0; left:0; right: 0;
	   background-color: var(--white);
	   z-index: 1000;
	   border-bottom: var(--border);
	}
	.header .flex{
	   display: flex;
	   align-items: center;
	   justify-content: space-between;
	   position: relative;
	   padding: 1.5rem 2rem;
	}
	body{
	   background-color: var(--light-bg);
	   padding-left: 0rem;
	}
    .courses .box-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr); 
        gap: 1.5rem;
        justify-content: center;
        align-items: flex-start;
    }

    /* Individual course box styles */
    .courses .box-container .box {
        border-radius: .5rem;
        background-color: var(--white);
        padding: 2rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Tutor section within the course box */
    .courses .box-container .box .tutor {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    /* Tutor image styles */
    .courses .box-container .box .tutor img {
        height: 5rem;
        width: 5rem;
        border-radius: 50%;
        object-fit: cover;
    }

    /* Tutor name styles */
    .courses .box-container .box .tutor h3 {
        font-size: 1.8rem;
        color: var(--black);
        margin-bottom: .2rem;
    }

    /* Tutor additional info styles */
    .courses .box-container .box .tutor span {
        font-size: 1.3rem;
        color: var(--light-color);
    }

    /* Course thumbnail container styles */
    .courses .box-container .box .thumb {
        position: relative;
    }

    /* Overlay span on the course thumbnail */
    .courses .box-container .box .thumb span {
        position: absolute;
        top: 1rem;
        left: 1rem;
        border-radius: .5rem;
        padding: .5rem 1.5rem;
        background-color: rgba(0, 0, 0, .3);
        color: #fff;
        font-size: 1.5rem;
    }

    /* Course thumbnail image styles */
    .courses .box-container .box .thumb img {
        width: 100%;
        height: 20rem;
        object-fit: cover;
        border-radius: .5rem;
    }

    /* Course title styles */
    .courses .box-container .box .title {
        font-size: 2rem;
        color: var(--black);
        padding-bottom: .5rem;
        padding-top: 1rem;
    }

    /* "Load More" button styles */
    .courses .more-btn {
        text-align: center;
        margin-top: 2rem;
    }

    /* Add button styles */
    .addbtn {
        background-color: #b37bc8;
        font-size: 1.5rem;
        width: 4.5rem;
    }

    /* Responsive Styles for mobile devices */
    @media (max-width: 768px) {
        .courses .box-container {
            grid-template-columns: 1fr;
        }

        .courses .box-container .box {
            max-width: 100%;
        }
    }

.playlist-videos .box-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    justify-content: center;
    align-items: flex-start;
}

.playlist-videos .box-container .box {
    border-radius: .5rem;
    background-color: var(--white);
    padding: 2rem;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    position: relative;
    margin-bottom: 1.5rem; /* Adjust margin between boxes */
}

.playlist-videos .box-container .box .thumb {
    position: relative;
}

.playlist-videos .box-container .box .thumb span {
    position: absolute;
    top: 1rem;
    left: 1rem;
    border-radius: .5rem;
    padding: .5rem 1.5rem;
    background-color: rgba(0, 0, 0, .3);
    color: #fff;
    font-size: 1.5rem;
}

.playlist-videos .box-container .box img {
    width: 100%;
    height: 20rem;
    object-fit: cover;
    border-radius: .5rem;
}

.playlist-videos .box-container .box h3 {
    font-size: 2rem;
    color: var(--black);
    padding-bottom: .5rem;
    padding-top: 1rem;
    margin-top: 1.5rem;
}

.playlist-videos .box-container .box .tutor {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 2.5rem;
}

.playlist-videos .box-container .box .tutor img {
    height: 5rem;
    width: 5rem;
    border-radius: 50%;
    object-fit: cover;
}

.playlist-videos .box-container .box .tutor h3 {
    font-size: 1.8rem;
    color: var(--black);
    margin-bottom: .2rem;
}

.playlist-videos .box-container .box .tutor span {
    font-size: 1.3rem;
    color: var(--light-color);
}

@media (max-width: 768px) {
    .playlist-videos .box-container {
        grid-template-columns: 1fr;
    }
}


</style>
