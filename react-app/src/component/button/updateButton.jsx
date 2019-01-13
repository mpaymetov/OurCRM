import React, {Component} from 'react';
import {Link, BrowserRouter, BrowserRouter as Router, Route} from 'react-router-dom';

class UpdateButton extends Component {

    render() {
        return(
            <nav>
                <Link to={this.props.buttonInfo.path} className="btn btn-primary"> {this.props.buttonInfo.buttonName} </Link>
            </nav>
        );
    }

}

export default UpdateButton;