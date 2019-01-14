import React, {Component} from 'react';


class FifthColumn extends Component {
    constructor(props) {
        super(props);
        const column = this.props.column;

    }

    render() {
        console.log(" fifth state", this.state);
        return(
            <div>sdbg</div>
        );
    }
}

export default FifthColumn;