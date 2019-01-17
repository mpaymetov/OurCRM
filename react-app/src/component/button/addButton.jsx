import React, {Component} from 'react';
import {Link, BrowserRouter, BrowserRouter as Router, Route} from 'react-router-dom';

class AddButton extends Component {

    render() {
        return (
            <nav>
                <Link to={this.props.buttonInfo.path}
                      className="btn btn_create"> {this.props.buttonInfo.buttonName} </Link>
            </nav>
        );
    }

}

export default AddButton;