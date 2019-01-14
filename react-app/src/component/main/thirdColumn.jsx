import React, {Component} from 'react';


class ThirdColumn extends Component {
    constructor(props) {
        super(props);
        const column = this.props;

    }

    render() {
        console.log(" third state", this.state);
        if (this.state !== null) {
            return (
                <div>sdbg</div>
            );
        }
        return <p>пока нет событий</p>
    }
}

export default ThirdColumn;