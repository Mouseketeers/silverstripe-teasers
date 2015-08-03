<% if ManagedTeasers %>
<ul class="teasers medium-block-grid-{$NumColumns}">
	<% loop ManagedTeasers %>
	<li class="teaser">
		<% if Title %><h3>$Title</h3><% end_if %>
		<% if Image %>$Image.SetWidth(300)<% end_if %>
		$Content
		<p>
		<% if Link || ExternalLink %>
			<a href="<% if Link %>$Link.URLSegment<% else_if ExternalLink %>$ExternalLink<% end_if %>">
				<% if LinkTitle %>$LinkTitle<% else %>Read more<% end_if %>
			</a>
		<% end_if %>
		</p>
	</li>
	<% end_loop %>
</ul>
<% end_if %>


	
