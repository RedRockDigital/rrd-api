export default window.app.groups.map(group => ({
    value: group.id,
    label: group.name,
}));
