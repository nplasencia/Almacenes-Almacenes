<footer class="Footer bg-dark dker">
    <p>2016 &copy; Nauzet Plasencia - Auret </p>
</footer><!-- /#footer -->

<!-- #helpModal -->
<div id="helpModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Ayuda</h4>
            </div>
            <div class="modal-body">
                <p>
                    Esta aplicación ha sido desarrollada por la empresa Auret S.L. Si tienes cualquier problema, no dudes en contactar con ellos a través del email
                    <a href="mailto:nplasencia@auret.es?subject=[CuadrantesApp]%20Ayuda">nplasencia@auret.es</a>.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal --><!-- /#helpModal -->

<script src="{{ asset('assets/js/app.min.js') }}"></script>

@stack('scripts')