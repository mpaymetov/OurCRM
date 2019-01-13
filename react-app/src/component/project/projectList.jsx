import React, {Component} from 'react';
import {Link, BrowserRouter, BrowserRouter as Router, Route} from 'react-router-dom';

const API = '/api/projects';

class ProjectList extends Component {
    constructor(props) {
        super(props);
        this.state = {jsonData: ''};
    }

    componentWillMount() {
        fetch(API)
            .then(response => response.json())
            .then(data => this.setState({jsonData: data}))
            .catch((error) => {
                console.error(error);
            });
    }
    
    render() {
        if (this.state.jsonData !== '') {

            console.log(this.state.jsonData);

            return(
                <div>

                    {this.state.jsonData.items.map(
                        {elem} =>
                    )}
                </div>
            );
        } else {
            return(
                <div></div>
            );
        }
        
    }

}

export default ProjectList;